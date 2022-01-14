<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $attributes = [
        'status' => 'unpaid'
    ];
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function orderitems() {
        return $this->hasMany(Orderitem::class, 'order_kodeSewa', 'kodeSewa');
    }
}
