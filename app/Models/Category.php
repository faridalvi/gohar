<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'name','slug','parent_id','created_by','updated_by'
    ];
    //Product
    public function mainCategoryproduct(){
        return $this->hasMany(Product::class,'main_category_id');
    }
    public function subCategoryproduct(){
        return $this->hasMany(Product::class,'sub_category_id');
    }
    //Parent Has Children
    public function children() {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function parent() {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
