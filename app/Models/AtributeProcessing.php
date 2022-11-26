<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtributeProcessing extends Model
{
    use HasFactory;
    protected $table = 'atribute_processings';
    protected $fillable = [
        'name','description','created_by','updated_by'
    ];
    //Product
    public function product(){
        return $this->hasMany(Product::class,'atribute_processing_id');
    }
}
