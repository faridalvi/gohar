<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'fabric_types';
    protected $fillable = [
        'entry','date','name','sale_order','category_id','season_id','age_group_id','country_id','region_id','customer_id','loom_type_id','greige_quality',
        'composition','finish_fabric_quality','gsm','process','atribute_yarn_id','atribute_weaving_id','atribute_processing_id','atribute_stitching_id',
        'fabric_type_id','description','image','gallery','created_by','updated_by'
    ];
    //Category
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    //Season
    public function season(){
        return $this->belongsTo(Season::class,'season_id');
    }
    //Age Group
    public function ageGroup(){
        return $this->belongsTo(AgeGroup::class,'age_group_id');
    }
    //Country
    public function country(){
        return $this->belongsTo(Country::class,'country_id');
    }
    //Region
    public function region(){
        return $this->belongsTo(Region::class,'region_id');
    }
    //Customer
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
    //Loom Type
    public function loomType(){
        return $this->belongsTo(LoomType::class,'loom_type_id');
    }
    //Yarn
    public function yarn(){
        return $this->belongsTo(AtributeYarn::class,'atribute_yarn_id');
    }
    //Weaving
    public function weaving(){
        return $this->belongsTo(AtributeWeaving::class,'atribute_weaving_id');
    }
    //Processing
    public function processing(){
        return $this->belongsTo(AtributeProcessing::class,'atribute_processing_id');
    }
    //Stitching
    public function stitching(){
        return $this->belongsTo(AtributeProcessing::class,'atribute_stitching_id');
    }
    //Fabric
    public function fabric(){
        return $this->belongsTo(FabricType::class,'fabric_type_id');
    }
}
