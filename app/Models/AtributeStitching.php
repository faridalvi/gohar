<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtributeStitching extends Model
{
    use HasFactory;
    //Product
    public function product(){
        return $this->hasMany(Product::class,'atribute_stitching_id');
    }
}
