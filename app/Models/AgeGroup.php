<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgeGroup extends Model
{
    use HasFactory;
    //Product
    public function product(){
        return $this->hasMany(Product::class,'age_group_id');
    }
}
