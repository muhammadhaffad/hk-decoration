<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function view(Request $request) {
        $order = Order::where('kodeSewa', $request->kodeSewa);
        return view('invoice-view', [
            'order' => $order->first()
        ]);
    }
}
