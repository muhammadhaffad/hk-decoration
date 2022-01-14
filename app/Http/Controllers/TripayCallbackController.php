<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;


class TripayCallbackController extends Controller
{

    public function handle(Request $request)
    {
        $privateKey = env('TRIPAY_PRIVATE_KEY');

        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        $signature = hash_hmac('sha256', $json, $privateKey);

        if ($signature !== (string) $callbackSignature) {
            return 'Invalid signature';
        }

        if ('payment_status' !== (string) $request->server('HTTP_X_CALLBACK_EVENT')) {
            return 'Invalid callback event, no action was taken';
        }

        $data = json_decode($json);
        $merchantRef = $data->merchant_ref;

        $order = Order::where('kodeSewa', $merchantRef)
            ->where('status', 'unpaid')
            ->with('orderitems')
            ->first();

        if (!$order) {
            return 'Invoice not found or current status is not unpaid';
        }

        switch ($data->status) {
            case 'PAID':
                $order->update(['status' => 'paid']);
                return response()->json(['success' => true]);

            case 'EXPIRED':
                $order->update(['status' => 'expired']);
                foreach ($order->orderitems as $item) {
                    $product = $item->orderable()->first();
                    if ($product->jmldisewa > 0) {
                        $product->jmldisewa -= $item->kuantitas;
                        $product->save();
                    }
                }
                return response()->json(['success' => true]);

            case 'FAILED':
                $order->update(['status' => 'failed']);
                foreach ($order->orderitems as $item) {
                    $product = $item->orderable()->first();
                    if ($product->jmldisewa > 0) {
                        $product->jmldisewa -= $item->kuantitas;
                        $product->save();
                    }
                }
                return response()->json(['success' => true]);

            case 'REFUND':
                $order->update(['status' => 'refund']);
                foreach ($order->orderitems as $item) {
                    $product = $item->orderable()->first();
                    if ($product->jmldisewa > 0) {
                        $product->jmldisewa -= $item->kuantitas;
                        $product->save();
                    }
                }
                return response()->json(['success' => true]);

            default:
                return response()->json(['error' => 'Unrecognized payment status']);
        }
    }
}
