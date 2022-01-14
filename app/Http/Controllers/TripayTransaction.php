<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TripayTransaction extends Controller
{
    public function transaction($order, $method, $items, $type)
    {
        $apiKey       = env('TRIPAY_API_KEY');
        $privateKey   = env('TRIPAY_PRIVATE_KEY');
        $merchantCode = env('MERCHANT_CODE');
        $amount       = $order->total + $order->biayaongkir;

        $data = [
            'method'         => $method,
            'amount'         => $amount,
            'customer_name'  => $order->nama,
            'customer_email' => $order->user()->first()->email,
            'customer_phone' => $order->notlp,
            'order_items'    => array(),
            'return_url'   => 'http://127.0.0.1:8000/myorder',
            'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
            'signature'    => hash_hmac('sha256', $merchantCode . $amount, $privateKey)
        ];

        $hargasewas = explode(',', $order->hargaSewa);
        foreach ($items as $i => $item) {
            $price = $item->cartable()->first()->harga;
            $price += $hargasewas[$i] * $order->lamaSewa;
            $data['order_items'][] = [
                'name' => $item->cartable()->first()->nama,
                'price' => ($type == 'Uang muka' ? intval($price * 0.5) : $price),
                'quantity' => $item->kuantitas
            ];
        }

        $data['order_items'][] = [
            'name' => 'ongkir',
            'price' => $order->biayaongkir,
            'quantity' => 1
        ];
        
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => 'https://tripay.co.id/api-sandbox/transaction/create',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($data),
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        return json_decode($response) ?: $error;
    }

    public function detailTransaction($code)
    {
        $apiKey = env('TRIPAY_API_KEY');

        $payload = ['reference' => $code];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => 'https://tripay.co.id/api-sandbox/transaction/detail?' . http_build_query($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        return json_decode($response)->data ?: $error;
    }
}
