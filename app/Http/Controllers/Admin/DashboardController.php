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

        $data['products'] = Product::orderBy('id','desc')->get();
        return response()->json($data);
    }
}
