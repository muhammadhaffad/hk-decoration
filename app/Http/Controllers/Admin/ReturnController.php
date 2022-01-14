<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function view(Request $request)
    {
        $request->validate([
            'status' => 'nullable|in:true,false'
        ]);
        $orders = new Order;
        if ($request->status === 'true') {
            $orders = $orders->where('status', 'paid')->where('tanggalKembali', '!=',null)->with('orderitems');
        } else {
            $orders = $orders->where('status', 'paid')->where('tanggalKembali', null)->with('orderitems');
        }
        return view('admin.return', [
            'orders' => $orders
        ]);
    }

    public function confirm(Request $request) {
        $request->validate([
            'kodeSewa' => 'required',
        ]);
        $order = Order::where('kodeSewa',$request->kodeSewa)->with('orderitems')->first();
        if ($order->tanggalKembali == null) {
            $order->tanggalKembali = date('Y-m-d');
            $order->save();
            foreach ($order->orderitems as $orderitem ) {
                $orderitem->tanggalKembali = date('Y-m-d');
                $orderitem->save();
                $item = $orderitem->orderable()->first();
                if ($item->jmldisewa > 0) {
                    $item->jmldisewa -= $orderitem->kuantitas;
                    $item->save();
                }
            }
        }
        return back();
    }
}
