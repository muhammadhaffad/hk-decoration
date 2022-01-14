<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract, JWTSubject
{
    use SoftDeletes;    
    use Authenticatable;
    
    protected $guarded = [];
    protected $attributes = [
        'status' => 'active'
    ];

    public function customer() {
        return $this->hasOne(Customer::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function checkouts() {
        return $this->hasMany(Checkout::class);
    }

    public function carts() {
        return $this->hasMany(Cart::class);
    }

    public function testimonials() {
        return $this->hasMany(Testimonial::class);
    }

    public function chats() {
        return $this->hasMany(Chat::class);
    }

    public function hasRole($param) {
        return $this->role === $param;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
