<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sessionpackage extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    protected $table = 'sessionpackages';

    public function carts()
    {
        return $this->morphMany(Cart::class, 'cartable');
    }

    public function orders()
    {
        return $this->morphMany(Orderitem::class, 'orderable');
    }

    public function testimonials()
    {
        return $this->morphMany(Testimonial::class, 'testimoniable');
    }

    public function chats()
    {
        return $this->morphMany(Chat::class, 'orderable', 'orderable_type', 'orderable_id');
    }

    public function getTableName()
    {
        return $this->table;
    }
}
