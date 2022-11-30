<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AtributeWeaving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AtributeWeavingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:atribute-weaving-list', ['only' => ['index']]);
        $this->middleware('permission:atribute-weaving-create', ['only' => ['create','store']]);
        $this->middleware('permission:atribute-weaving-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:atribute-weaving-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.weaving.index');
    }
    public function getAtributeWeaving(Request $request){
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
        $totalRecords = AtributeWeaving::select('count(*) as allcount')->count();
        $totalRecordswithFilter = AtributeWeaving::select('count(*) as allcount')->where(function ($q) use ($searchValue){
            $q->where('name', 'like', '%' .$searchValue . '%')
                ->where('description', 'like', '%' .$searchValue . '%');
        })->count();
        // Fetch records
        $records = AtributeWeaving::orderBy($columnName,$columnSortOrder)
            ->where(function ($q) use ($searchValue){
                $q->where('name', 'like', '%' .$searchValue . '%')
                    ->where('description', 'like', '%' .$searchValue . '%');
            })
            ->select('atribute_weavings.*')
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
        return view('admin.weaving.create');
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
            'name' => 'required|unique:atribute_weavings,name',
            'description' => 'required',
        ]);
        $userId = Auth::user()->id;
        $weaving  = new AtributeWeaving();
        $weaving->name = $request->name;
        $weaving->description = $request->description;
        $weaving->created_by = $userId;
        $weaving->updated_by = $userId;
        $saved = $weaving->save();
        if (!empty($saved)){
            return redirect(route('atribute-weaving.index'))->with('message','Weaving created successfully');
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
        $weaving = AtributeWeaving::find($id);
        return view('admin.weaving.edit',compact('weaving'));
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
            'name' => 'required|unique:atribute_weavings,name,'.$id,
            'description' => 'required',
        ]);
        $userId = Auth::user()->id;
        $weaving  = AtributeWeaving::find($id);
        $weaving->name = $request->name;
        $weaving->description = $request->description;
        $weaving->updated_by = $userId;
        $saved = $weaving->save();
        if (!empty($saved)){
            return redirect(route('atribute-weaving.index'))->with('message','Weaving Updated successfully');
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
        $weaving = AtributeWeaving::find($id);
        if ($weaving->product->count() > 0){
            return redirect(route('atribute-weaving.index'))->with('warning','Please Delete its Product First');
        }
        $weaving->delete();
        return redirect()->route('atribute-weaving.index')->with('message','Weaving deleted successfully');
    }
}
