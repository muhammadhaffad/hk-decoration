<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class UnpaidController extends Controller
{
    public function view(Request $request)
    {
        $payments = new Payment;
        $payments = $payments->where('status', null);
        return view('admin.unpaid', [
            'payments' => $payments
        ]);
    }

    public function destroy(Request $request) {
        $payment = Payment::find($request->payment_id);
        $order = $payment->order()->first();
        $orderitems = $order->orderitems();
        foreach ($orderitems->get() as $orderitem ) {
            $item = $orderitem->orderable()->first();
            if ($item->jmldisewa > 0) {
                $item->jmldisewa -= $orderitem->kuantitas;
                $item->save();
            }
        }
        $orderitems->delete();
        $order->delete();
        $payment->delete();
        return back();
    }
}
