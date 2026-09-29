<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    private function generateSignature(string $message): string
    {
        $secret = config('services.esewa.secret');
        return base64_encode(hash_hmac('sha256', $message, $secret, true));
    }

    public function initiate(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $total     = number_format($order->total_amount, 2, '.', '');
        $uuid      = $order->esewa_transaction_uuid;
        $code      = config('services.esewa.merchant_code');
        $message   = "total_amount={$total},transaction_uuid={$uuid},product_code={$code}";
        $signature = $this->generateSignature($message);

        $params = [
            'amount'                 => $total,
            'tax_amount'             => '0',
            'total_amount'           => $total,
            'transaction_uuid'       => $uuid,
            'product_code'           => $code,
            'product_service_charge' => '0',
            'product_delivery_charge'=> '0',
            'success_url'            => route('payment.esewa.success'),
            'failure_url'            => route('payment.esewa.failure'),
            'signed_field_names'     => 'total_amount,transaction_uuid,product_code',
            'signature'              => $signature,
        ];

        $endpoint = config('services.esewa.endpoint');
        return view('payment.esewa-form', compact('params', 'endpoint'));
    }

    public function success(Request $request)
    {
        try {
            $encoded = $request->get('data') ?? $request->get('response');
            if (!$encoded) {
                return redirect()->route('home')->with('error', 'Invalid payment response.');
            }

            $decoded = json_decode(base64_decode($encoded), true);
            if (!$decoded) {
                return redirect()->route('home')->with('error', 'Could not decode payment response.');
            }

            // Verify signature from response
            $signedFieldNames = $decoded['signed_field_names'] ?? 'transaction_code,status,total_amount,transaction_uuid,product_code,signed_field_names';
            $fields           = explode(',', $signedFieldNames);
            $parts            = [];
            foreach ($fields as $field) {
                $field   = trim($field);
                $parts[] = "{$field}=" . ($decoded[$field] ?? '');
            }
            $message       = implode(',', $parts);
            $expectedSig   = $this->generateSignature($message);
            $receivedSig   = $decoded['signature'] ?? '';

            if (!hash_equals($expectedSig, $receivedSig)) {
                Log::warning('eSewa signature mismatch', ['decoded' => $decoded]);
                return redirect()->route('home')->with('error', 'Payment signature verification failed.');
            }

            $uuid  = $decoded['transaction_uuid'] ?? null;
            $order = Order::where('esewa_transaction_uuid', $uuid)->firstOrFail();

            if ($order->payment_status === 'paid') {
                return redirect()->route('orders.confirm', $order->id);
            }

            // Optional status check API
            $statusUrl = config('services.esewa.status_endpoint');
            $code      = config('services.esewa.merchant_code');
            $total     = number_format($order->total_amount, 2, '.', '');

            try {
                $statusRes = Http::timeout(10)->get($statusUrl, [
                    'product_code'  => $code,
                    'total_amount'  => $total,
                    'transaction_uuid' => $uuid,
                ]);
                $statusData = $statusRes->json();
                if (($statusData['status'] ?? '') !== 'COMPLETE') {
                    $order->update(['payment_status' => 'failed']);
                    return redirect()->route('home')->with('error', 'Payment not completed per eSewa status check.');
                }
                $esewaRefId = $statusData['ref_id'] ?? $decoded['transaction_code'] ?? null;
            } catch (\Exception $e) {
                Log::warning('eSewa status API failed, trusting signature', ['error' => $e->getMessage()]);
                $esewaRefId = $decoded['transaction_code'] ?? null;
            }

            DB::transaction(function () use ($order, $esewaRefId) {
                $order->update([
                    'payment_status' => 'paid',
                    'order_status'   => 'processing',
                    'esewa_ref_id'   => $esewaRefId,
                ]);

                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->decrement('stock_quantity', $item->quantity);
                    }
                }

                $cart = Cart::where('user_id', $order->user_id)->first();
                if ($cart) {
                    CartItem::where('cart_id', $cart->id)->delete();
                }
            });

            return redirect()->route('orders.confirm', $order->id)
                             ->with('success', 'Payment successful! Your order is confirmed.');

        } catch (\Exception $e) {
            Log::error('eSewa success handler error', ['error' => $e->getMessage()]);
            return redirect()->route('home')->with('error', 'An error occurred processing payment. Contact support.');
        }
    }

    public function failure(Request $request)
    {
        try {
            $encoded = $request->get('data') ?? $request->get('response');
            if ($encoded) {
                $decoded = json_decode(base64_decode($encoded), true);
                $uuid    = $decoded['transaction_uuid'] ?? null;
                if ($uuid) {
                    Order::where('esewa_transaction_uuid', $uuid)
                         ->update(['payment_status' => 'failed']);
                }
            }
        } catch (\Exception $e) {
            Log::warning('eSewa failure handler error', ['error' => $e->getMessage()]);
        }

        return redirect()->route('profile.orders')
                         ->with('error', 'Payment was not completed. You can retry from your orders.');
    }
}
