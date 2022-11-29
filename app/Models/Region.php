<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $table = 'regions';
    protected $fillable = [
        'name','code','country_id','created_by','updated_by'
    ];
    //Country
    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }
    //Product
    public function product(){
        return $this->hasMany(Product::class,'region_id');
    }
}
