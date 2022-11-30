<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgeGroup;
use App\Models\AtributeProcessing;
use App\Models\AtributeStitching;
use App\Models\AtributeWeaving;
use App\Models\AtributeYarn;
use App\Models\Category;
use App\Models\Country;
use App\Models\Customer;
use App\Models\FabricType;
use App\Models\LoomType;
use App\Models\Product;
use App\Models\Region;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:product-list', ['only' => ['index']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.index');
    }
    public function getProducts(Request $request){
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Product::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Product::select('count(*) as allcount')->where(function ($q) use ($searchValue){
            $q->where('name', 'like', '%' .$searchValue . '%')
                ->where('description', 'like', '%' .$searchValue . '%');
        })->count();
        // Fetch records
        $records = Product::orderBy($columnName,$columnSortOrder)
            ->where(function ($q) use ($searchValue){
                $q->where('name', 'like', '%' .$searchValue . '%')
                    ->where('description', 'like', '%' .$searchValue . '%');
            })
            ->select('products.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach($records as $record){
            $id = $record->id;
            $name = $record->name;
            $customer = (isset($record->customer) ? $record->customer->name : '');
            $subCategory = (isset($record->category) ? $record->category->name : '');
            $subCategoryId =(isset($record->category) ? $record->category->id : '');
            $category = Category::where('id',$subCategoryId)->first();
            $parentCategory = (isset($category) ? $category->parent->name : '');
            $season = (isset($record->season) ? $record->season->name : '');
            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "customer" => $customer,
                "sub_category" => $subCategory,
                "parent_category" => $parentCategory,
                "season" => $season,
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::whereHas('children')->orderBy('id','desc')->get();
        $seasons = Season::orderBy('id','desc')->get();
        $ageGroups = AgeGroup::orderBy('id','desc')->get();
        $countries = Country::orderBy('name','asc')->get();
        $customers = Customer::orderBy('id','asc')->get();
        $looms = LoomType::orderBy('id','asc')->get();
        $yarns = AtributeYarn::orderBy('id','asc')->get();
        $weavings = AtributeWeaving::orderBy('id','asc')->get();
        $processings = AtributeProcessing::orderBy('id','asc')->get();
        $stitchings = AtributeStitching::orderBy('id','asc')->get();
        $fabrics = FabricType::orderBy('id','asc')->get();
        return view('admin.product.create',compact('categories','seasons','ageGroups','countries','customers','looms','yarns',
        'weavings','processings','stitchings','fabrics'));
    }
    public function fetchCategories(Request $request)
    {
        $data['categories'] = Category::where("parent_id",$request->main_category_id)->get(["name", "id"]);
        return response()->json($data);
    }
    public function fetchRegions(Request $request)
    {
        $data['regions'] = Region::where("country_id",$request->country_id)->get(["name", "id"]);
        return response()->json($data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'entry' => 'required|unique:products,entry',
            'date' => 'required',
            'name' => 'required|unique:products,name',
            'sale_order' => 'required',
            'main_category' => 'required',
            'sub_category' => 'required',
            'season' => 'required',
            'age_group' => 'required',
            'country' => 'required',
            'region' => 'required',
            'customer' => 'required',
            'loom_type' => 'required',
            'greige_quality' => 'required',
            'composition' => 'required',
            'finish_fabric_quality' => 'required',
            'gsm' => 'required',
            'process' => 'required',
            'atribute_yarn' => 'required',
            'atribute_weaving' => 'required',
            'atribute_processing' => 'required',
            'atribute_stitching' => 'required',
            'fabric_type' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery' => 'required',
        ]);
        // Upload Image
        if ($request->hasFile('image')) {
            $getImage = date('Y').'/'.time().'-'.rand(0,999999).'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('product/').date('Y'), $getImage);
            $image = $getImage;
        }
        else{
            $image='';
        }
        // Upload Gallery
        if ($request->hasFile('gallery')) {
            foreach($request->file('gallery') as $file)
            {
                $getImage = date('Y').'/'.time().'-'.rand(0,999999).'.'.$file->getClientOriginalExtension();
                $file->move(public_path('product/gallery/').date('Y'), $getImage);
                $images[] = $getImage;
            }
            $gallery = json_encode($images);

        }
        else{
            $gallery='';
        }
        $date = date('d/m/Y',strtotime($request->date));
        $userId = Auth::user()->id;
        $product  = new Product();
        $product->entry = $request->entry;
        $product->date = $date;
        $product->name = $request->name;
        $product->sale_order = $request->sale_order;
        $product->category_id = $request->sub_category;
        $product->season_id = $request->season;
        $product->age_group_id = $request->age_group;
        $product->country_id = $request->country;
        $product->region_id = $request->region;
        $product->customer_id = $request->customer;
        $product->loom_type_id = $request->loom_type;
        $product->greige_quality = $request->greige_quality;
        $product->composition = $request->composition;
        $product->finish_fabric_quality = $request->finish_fabric_quality;
        $product->gsm = $request->gsm;
        $product->process = $request->process;
        $product->atribute_yarn_id = $request->atribute_yarn;
        $product->atribute_weaving_id = $request->atribute_weaving;
        $product->atribute_processing_id = $request->atribute_processing;
        $product->atribute_stitching_id = $request->atribute_stitching;
        $product->fabric_type_id = $request->fabric_type;
        $product->description = $request->description;
        $product->image = $image;
        $product->gallery = $gallery;
        $product->created_by = $userId;
        $product->updated_by = $userId;
        $saved = $product->save();
        if (!empty($saved)){
            return redirect(route('product.index'))->with('message','Product created successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('admin.product.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:products,name,'.$id,
            'description' => 'required',
        ]);
        $userId = Auth::user()->id;
        $product  = Product::find($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->updated_by = $userId;
        $saved = $product->save();
        if (!empty($saved)){
            return redirect(route('product.index'))->with('message','Product Updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->route('product.index')->with('success','Product deleted successfully');
    }
}
