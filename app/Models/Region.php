<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    //Product
    public function product(){
        return $this->hasMany(Product::class,'region_id');
    }
}
