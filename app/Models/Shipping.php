<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipping extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    public function regency() {
        return $this->belongsTo(Regency::class);
    }

    public function district() {
        return $this->belongsTo(District::class);
    }
}
