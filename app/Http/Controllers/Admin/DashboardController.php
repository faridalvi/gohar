<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AtributeYarn;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Region;
use App\Models\Season;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $categories = Category::whereHas('children')->orderBy('id','desc')->get();
        $customers = Customer::orderBy('id','asc')->get();
        $seasons = Season::orderBy('id','desc')->get();
        $regions = Region::orderBy('id','desc')->get();
        $yarns = AtributeYarn::orderBy('id','asc')->get();
        return view('admin.dashboard',compact('categories','customers','seasons','regions','yarns'));
    }
    public function getDashboardProducts(Request $request){
        $main = $request->get('main');
        $sub = $request->get('sub');
        $customerId = $request->get('customerId');
        $seasonId = $request->get('seasonId');
        $regionId = $request->get('regionId');
        $yarnId = $request->get('yarnId');
        $data['products'] = Product::orderBy('id','desc')->where(function ($q) use ($main,$sub,$customerId,$seasonId,$regionId,$yarnId){
            if (!empty($main)){
                $q->where('main_category_id',$main);
            }
            if (!empty($sub)){
                $q->where('sub_category_id',$sub);
            }
            if (!empty($seasonId)){
                $q->where('season_id',$seasonId);
            }
            if (!empty($regionId)){
                $q->where('region_id',$regionId);
            }
            if (!empty($customerId)){
                $q->where('customer_id',$customerId);
            }
            if (!empty($yarnId)){
                $q->where('atribute_yarn_id',$yarnId);
            }
        })->get();
        return response()->json($data);
    }
}
