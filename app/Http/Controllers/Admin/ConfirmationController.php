<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class ConfirmationController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'status' => 'nullable|in:unpaid,paid,expired,failed,refund'
        ]);
        $orders = new Order;
        $status = 'unpaid';
        if (isset($request->status)) {
            $status = $request->status;
        }
        $orders = $orders->where('status', $status);

        return view('admin.confirmation', [
            'orders' => $orders
        ]);
    }

    // public function confirm(Request $request) {
    //     $payment = Payment::find($request->payment_id);
    //     $payment->status = 'Sudah dikonfirmasi';
    //     $payment->save();
    //     return back();
    // }

    // public function fail(Request $request) {
    //     $payment = Payment::find($request->payment_id);
    //     $payment->status = 'Gagal dikonfirmasi';
    //     $payment->save();
    //     return back();
    // }

    // public function destroy(Request $request) {
    //     $payment = Payment::find($request->payment_id);
    //     $order = $payment->order()->first();
    //     $orderitems = $order->orderitems();

    //     $orderitems->delete();
    //     $order->delete();
    //     $payment->delete();
    //     return back();
    // }

    // public function detailOrder(Request $request) {
    //     $order = Order::find($request->id);
    //     return response()->json($order);
    // }
}
