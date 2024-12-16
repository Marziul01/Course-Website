<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentRequest;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\User;
use App\Notifications\NewContactNotification;
use App\Notifications\ProductQtyNotification;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

class DashboardController extends Controller
{
    public function index(){
        $totalIncome = Order::where('status', 2)->sum('grand_total');
        $currentMonthIncome = Order::where('status', 2)
        ->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->sum('grand_total');

        $totalUsers = User::where('role', 0)->where('status', 0 )->count();
        $totalPendingOrders = Order::where('status', 1)->count();

        $monthlyEarnings = array_fill(0, 12, 0);

        $completedOrders = Order::where('status', 2)->get();

        foreach ($completedOrders as $order) {
            $month = Carbon::parse($order->created_at)->month;
            $monthlyEarnings[$month - 1] += $order->grand_total;
        }

        return view('admin.dashboard.dashboard',[
            'totalIncome' => $totalIncome,
            'currentMonthIncome' => $currentMonthIncome,
            'totalUsers' => $totalUsers,
            'totalPendingOrders' => $totalPendingOrders,
            'affpay' => PaymentRequest::where('status',1)->count(),
            'monthlyEarnings' => $monthlyEarnings,
        ]);
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect(route('admin.login'));
    }

    public static function adminProfile(){
        return view('admin.auth.profile',[

        ]);
    }

    public static function Profilechange(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'password' => 'nullable|min:8|confirmed',
        ], [
            'name.required' => 'The name is required.',
            'email.required' => 'The email is required.',
            'email.unique' => 'The email is already taken.',
            'password.confirmed' => 'The password and confirmation do not match.',
            'password.min' => 'The password must be at least 8 characters.',
        ]);

        $admin = Auth::user();
        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }
        $admin->save();
        return back()->with('success', 'Profile details have been updated successfully');
    }


}
