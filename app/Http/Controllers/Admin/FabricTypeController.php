<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FabricType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FabricTypeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:fabric-type-list', ['only' => ['index']]);
        $this->middleware('permission:fabric-type-create', ['only' => ['create','store']]);
        $this->middleware('permission:fabric-type-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:fabric-type-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.fabric.index');
    }
    public function getFabricType(Request $request){
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
        $totalRecords = FabricType::select('count(*) as allcount')->count();
        $totalRecordswithFilter = FabricType::select('count(*) as allcount')->where(function ($q) use ($searchValue){
            $q->where('name', 'like', '%' .$searchValue . '%')
                ->where('description', 'like', '%' .$searchValue . '%');
        })->count();
        // Fetch records
        $records = FabricType::orderBy($columnName,$columnSortOrder)
            ->where(function ($q) use ($searchValue){
                $q->where('name', 'like', '%' .$searchValue . '%')
                    ->where('description', 'like', '%' .$searchValue . '%');
            })
            ->select('fabric_types.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach($records as $record){
            $id = $record->id;
            $name = $record->name;
            $description = $record->description;
            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "description" => $description,
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
        return view('admin.fabric.create');
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
            'name' => 'required|unique:fabric_types,name',
            'description' => 'required',
        ]);
        $userId = Auth::user()->id;
        $fabric  = new FabricType();
        $fabric->name = $request->name;
        $fabric->description = $request->description;
        $fabric->created_by = $userId;
        $fabric->updated_by = $userId;
        $saved = $fabric->save();
        if (!empty($saved)){
            return redirect(route('fabric-type.index'))->with('message','Fabric created successfully');
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
        $fabric = FabricType::find($id);
        return view('admin.fabric.edit',compact('fabric'));
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
            'name' => 'required|unique:fabric_types,name,'.$id,
            'description' => 'required',
        ]);
        $userId = Auth::user()->id;
        $fabric  = FabricType::find($id);
        $fabric->name = $request->name;
        $fabric->description = $request->description;
        $fabric->updated_by = $userId;
        $saved = $fabric->save();
        if (!empty($saved)){
            return redirect(route('fabric-type.index'))->with('message','Fabric Updated successfully');
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
        $fabric = FabricType::find($id);
        $fabric->delete();
        return redirect()->route('fabric-type.index')->with('success','Fabric deleted successfully');
    }
}
