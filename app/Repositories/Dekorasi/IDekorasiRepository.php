<?php

namespace App\Repositories\Dekorasi;

interface IDekorasiRepository {
    public function getAllDekor($request);
    public function getAllPaket($request);
}