<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orderitem extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    
    public function orderable() {
        return $this->morphTo();
    }

    public function order() {
        return $this->belongsTo(Order::class, 'order_kodeSewa', 'kodeSewa');
    }
}
