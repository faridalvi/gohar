<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:region-list', ['only' => ['index']]);
        $this->middleware('permission:region-create', ['only' => ['create','store']]);
        $this->middleware('permission:region-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:region-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.region.index');
    }
    public function getRegions(Request $request){
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
        $totalRecords = Region::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Region::select('count(*) as allcount')->where(function ($q) use ($searchValue){
            $q->where('name', 'like', '%' .$searchValue . '%');
        })->count();
        // Fetch records
        $records = Region::orderBy($columnName,$columnSortOrder)
            ->where(function ($q) use ($searchValue){
                $q->where('name', 'like', '%' .$searchValue . '%');
            })
            ->select('regions.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach($records as $record){
            $id = $record->id;
            $name = $record->name;
            $code = $record->code;
            $country = (isset($record->country) ? $record->country->name:'');
            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "code" => $code,
                "country" => $country,
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
        $countries = Country::orderBy('name','desc')->get();
        return view('admin.region.create',compact('countries'));
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
            'name' => 'required|unique:countries,name',
            'code' => 'required|unique:countries,code',
            'country_id' => 'required',
        ]);
        $userId = Auth::user()->id;
        $region  = new Region();
        $region->name = $request->name;
        $region->code = $request->code;
        $region->country_id = $request->country_id;
        $region->created_by = $userId;
        $region->updated_by = $userId;
        $saved = $region->save();
        if (!empty($saved)){
            return redirect(route('region.index'))->with('message','Region created successfully');
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
        $region = Region::find($id);
        $countries = Country::orderBy('name','desc')->get();
        return view('admin.region.edit',compact('region','countries'));
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
            'name' => 'required|unique:countries,name,'.$id,
            'code' => 'required|unique:countries,code,'.$id,
            'country_id' => 'required',
        ]);
        $userId = Auth::user()->id;
        $region  = Region::find($id);
        $region->name = $request->name;
        $region->code = $request->code;
        $region->country_id = $request->country_id;
        $region->updated_by = $userId;
        $saved = $region->save();
        if (!empty($saved)){
            return redirect(route('region.index'))->with('message','Region Updated successfully');
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
        $region = Region::find($id);
        $region->delete();
        return redirect()->route('region.index')->with('success','Region deleted successfully');
    }
}
