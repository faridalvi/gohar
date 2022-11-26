<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;
    protected $table = 'seasons';
    protected $fillable = [
        'name','slug','created_by','updated_by'
    ];
     //Product
     public function product(){
        return $this->hasMany(Product::class,'season_id');
    }

}
