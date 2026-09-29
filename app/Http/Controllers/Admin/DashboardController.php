<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::active()->count();
        $totalOrders   = Order::count();
        $totalRevenue  = Order::where('payment_status', 'paid')->sum('total_amount');
        $recentOrders  = Order::with('user')->latest()->take(5)->get();

        // Last 7 days orders for chart
        $chartData = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $chartLabels = collect(range(6, 0))->map(fn($d) => now()->subDays($d)->format('M d'))->toArray();
        $chartValues = collect(range(6, 0))->map(fn($d) => $chartData[now()->subDays($d)->format('Y-m-d')] ?? 0)->toArray();

        return view('admin.dashboard', compact(
            'totalProducts', 'totalOrders', 'totalRevenue',
            'recentOrders', 'chartLabels', 'chartValues'
        ));
    }
}
