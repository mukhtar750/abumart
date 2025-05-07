<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Activity;
use App\Http\Controllers\Controller;

#[\Illuminate\Routing\Controller\Middleware('auth:admin', ['except' => ['showLoginForm', 'login']])]
class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $user = Auth::guard('admin')->user(); // Get the authenticated admin user

            if (!$user->has_changed_password) {
                return redirect()->route('admin.change-password'); // Redirect to change password
            }

            return redirect()->route('admin.dashboard'); // Redirect to dashboard
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function showChangePasswordForm()
    {
        return view('admin.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::guard('admin')->user();
        $user->password = Hash::make($request->new_password);
        $user->has_changed_password = true;
        $user->save();

        return redirect()->route('admin.dashboard'); // Or wherever you want to redirect
    }

    // Admin dashboard with Chart.js data visualization
    public function dashboard()
    {
        // Ensure admin authentication
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $recentActivities = Activity::orderBy('created_at', 'desc')->take(5)->get();

        // Calculate total sales from the orders table
        $totalSales = Order::sum('total_amount'); // Ensure 'total_amount' exists in the orders table

        // Fetch sales per day for chart visualization
        $salesData = Order::selectRaw("DATE(created_at) as date, SUM(total_amount) as total_sales")
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Format data for Chart.js
        $formattedSalesData = [
            'labels' => $salesData->pluck('date'),
            'data' => $salesData->pluck('total_sales'),
        ];

        return view('admin.dashboard', compact('totalProducts', 'totalOrders', 'totalUsers', 'recentActivities', 'totalSales', 'formattedSalesData'));
    }
}
