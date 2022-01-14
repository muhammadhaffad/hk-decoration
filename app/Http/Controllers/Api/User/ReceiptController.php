<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order\OrderResource;
use App\Models\Payment;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function index(Request $request) {
        $request->validate([
            'kodeSewa' => 'required'
        ]);
        $payment = new Payment;
        $order = $payment->whereHas('order', function($q) use($request) {
            $q->where('user_id', auth()->user()->id)->where('kodeSewa', $request->kodeSewa);
        })->first();
        return new OrderResource($order);
    }
}
