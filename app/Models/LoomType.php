<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoomType extends Model
{
    use HasFactory;
    protected $table = 'loom_types';
    protected $fillable = [
        'name','code','created_by','updated_by'
    ];
    //Product
    public function product(){
        return $this->hasMany(Product::class,'loom_type_id');
    }
}
