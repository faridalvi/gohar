<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoomTypeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:loom-type-list', ['only' => ['index']]);
        $this->middleware('permission:loom-type-create', ['only' => ['create','store']]);
        $this->middleware('permission:loom-type-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:loom-type-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.loom.index');
    }
    public function getLoomTypes(Request $request){
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
        $totalRecords = LoomType::select('count(*) as allcount')->count();
        $totalRecordswithFilter = LoomType::select('count(*) as allcount')->where(function ($q) use ($searchValue){
            $q->where('name', 'like', '%' .$searchValue . '%');
        })->count();
        // Fetch records
        $records = LoomType::orderBy($columnName,$columnSortOrder)
            ->where(function ($q) use ($searchValue){
                $q->where('name', 'like', '%' .$searchValue . '%');
            })
            ->select('loom_types.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach($records as $record){
            $id = $record->id;
            $name = $record->name;
            $code = $record->code;
            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "code" => $code,
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
        return view('admin.loom.create');
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
            'name' => 'required|unique:loom_types,name',
            'code' => 'required|unique:loom_types,code',
        ]);
        $userId = Auth::user()->id;
        $loom  = new LoomType();
        $loom->name = $request->name;
        $loom->code = $request->code;
        $loom->created_by = $userId;
        $loom->updated_by = $userId;
        $saved = $loom->save();
        if (!empty($saved)){
            return redirect(route('loom-type.index'))->with('message','Loom Type created successfully');
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
        $loom = LoomType::find($id);
        return view('admin.loom.edit',compact('loom'));
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
            'name' => 'required|unique:loom_types,name,'.$id,
            'code' => 'required|unique:loom_types,code,'.$id,
        ]);
        $userId = Auth::user()->id;
        $loom  = LoomType::find($id);
        $loom->name = $request->name;
        $loom->code = $request->code;
        $loom->updated_by = $userId;
        $saved = $loom->save();
        if (!empty($saved)){
            return redirect(route('loom-type.index'))->with('message','Loom Type Updated successfully');
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
        $loom = LoomType::find($id);
        if ($loom->product->count() > 0){
            return redirect(route('loom-type.index'))->with('warning','Please Delete its Product First');
        }
        $loom->delete();
        return redirect()->route('loom-type.index')->with('message','Loom Type deleted successfully');
    }
}
