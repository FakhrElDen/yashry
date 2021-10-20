<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'rate_per_gram',
        'shipping_discount',
        'vat'
    ];

    public function getDiscounts(){
        $discounts = $this->first();
        return $discounts;
    }
}
