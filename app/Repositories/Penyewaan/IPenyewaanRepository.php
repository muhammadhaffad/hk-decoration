<?php

namespace App\Repositories\Penyewaan;

interface IPenyewaanRepository {
    public function addDekorToCart($request);
    public function addPaketToCart($request);
}