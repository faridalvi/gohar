<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table = 'countries';
    protected $fillable = [
        'name','code','created_by','updated_by'
    ];
    //Product
    public function product(){
        return $this->hasMany(Product::class,'country_id');
    }
}
