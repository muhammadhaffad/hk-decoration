<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class ReorderController extends Controller
{
    public function index($code)
    {
        $order = Order::where('kodeSewa', $code)->with('orderitems')->first();
        if ($order !== null) {
            $items = [];
            foreach ($order->orderitems as $item) {
                $items[] = [
                    'user_id' => auth()->user()->id,
                    'kuantitas' => $item->kuantitas,
                    'cartable_type' => $item->orderable_type,
                    'cartable_id' => $item->orderable_id
                ];
            }
            Cart::insert($items);
            if (in_array($order->status, ['expired', 'failed', 'refund'])) {
                $order->delete();
                $order->orderitems()->delete();
            }
            return redirect('cart');
        }
    }
}
