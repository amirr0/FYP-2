<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $authUser = User::with('role')->where('id', Auth::user()->id)->first();
        $AuthUserRole = $authUser->role->name;
        $totalOrders = 0;
        $totalVendors = 0;
        $totalClient = 0;

        if ($AuthUserRole == 'Admin') {
            $totalOrders = Order::count();

            // Fetch total vendors
            $totalVendors = User::where('role_id', 2)->count();

            // Fetch total users
            $totalClient = User::where('role_id', 3)->count();
        } elseif ($AuthUserRole == "Vendor") { // Vendor
            // Fetch orders assigned to the vendor
            $totalOrders = Order::where('assigned_to', $authUser->id)->count();
        } elseif ($AuthUserRole == "Client") { // User
            // Fetch orders created by the user
            $totalOrders = Order::where('user_id', $authUser->id)->count();
        }

        return view('dashboard.index', compact('authUser', 'totalOrders', 'totalVendors', 'totalClient'));
    }
}
