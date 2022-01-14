<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function view()
    {
        $order = new Order;
        $paid = $order->where('status', 'paid')->count();
        $unpaid = $order->where('status', 'unpaid')->count();
        $expired = $order->where('status', 'expired')->count();
        $failed = $order->where('status', 'failed')->count();
        return view('admin.dashboard', [
            'count' => [
                'paid' => $paid,
                'unpaid' => $unpaid,
                'expired' => $expired,
                'failed' => $failed
            ]
        ]);
    }
}
