<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtributeYarn extends Model
{
    use HasFactory;
    protected $table = 'atribute_yarns';
    protected $fillable = [
        'name','type','description','created_by','updated_by'
    ];
    //Product
    public function product(){
        return $this->hasMany(Product::class,'atribute_yarn_id');
    }
}
