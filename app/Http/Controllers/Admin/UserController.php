<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'customer')->withCount('orders')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function orders(User $user)
    {
        $orders = Order::where('user_id', $user->id)->with('items')->latest()->paginate(10);
        return view('admin.users.orders', compact('user', 'orders'));
    }

    public function destroy(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot delete admin users.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted.');
    }
}
