<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'weight',
        'price',
        'discount',
        'country_id'
    ];
    
    public function getProducts(){
        return $this->with(['country'])->get();
    }

    public function getProductbyId($id){
        return $this->with(['country'])->findOrFail($id);
    }

    public function getProductsDiscount(){
        return $this->pluck('discount', 'name');
    }
    
    public function country(){
        return $this->belongsTo(Country::class);
    }
}
