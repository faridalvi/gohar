<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    //Product
    public function product(){
        return $this->hasMany(Product::class,'customer_id');
    }
}
