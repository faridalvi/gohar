<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AtributeStitching;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AtributeStitchingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:atribute-stitching-list', ['only' => ['index']]);
        $this->middleware('permission:atribute-stitching-create', ['only' => ['create','store']]);
        $this->middleware('permission:atribute-stitching-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:atribute-stitching-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.stitching.index');
    }
    public function getAtributeStitching(Request $request){
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
        $totalRecords = AtributeStitching::select('count(*) as allcount')->count();
        $totalRecordswithFilter = AtributeStitching::select('count(*) as allcount')->where(function ($q) use ($searchValue){
            $q->where('name', 'like', '%' .$searchValue . '%')
                ->where('description', 'like', '%' .$searchValue . '%');
        })->count();
        // Fetch records
        $records = AtributeStitching::orderBy($columnName,$columnSortOrder)
            ->where(function ($q) use ($searchValue){
                $q->where('name', 'like', '%' .$searchValue . '%')
                    ->where('description', 'like', '%' .$searchValue . '%');
            })
            ->select('atribute_stitchings.*')
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
        return view('admin.stitching.create');
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
            'name' => 'required|unique:atribute_stitchings,name',
            'description' => 'required',
        ]);
        $userId = Auth::user()->id;
        $stitching  = new AtributeStitching();
        $stitching->name = $request->name;
        $stitching->description = $request->description;
        $stitching->created_by = $userId;
        $stitching->updated_by = $userId;
        $saved = $stitching->save();
        if (!empty($saved)){
            return redirect(route('atribute-stitching.index'))->with('message','Stitching created successfully');
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
        $stitching = AtributeStitching::find($id);
        return view('admin.stitching.edit',compact('stitching'));
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
            'name' => 'required|unique:atribute_stitchings,name,'.$id,
            'description' => 'required',
        ]);
        $userId = Auth::user()->id;
        $stitching  = AtributeStitching::find($id);
        $stitching->name = $request->name;
        $stitching->description = $request->description;
        $stitching->updated_by = $userId;
        $saved = $stitching->save();
        if (!empty($saved)){
            return redirect(route('atribute-stitching.index'))->with('message','Stitching Updated successfully');
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
        $stitching = AtributeStitching::find($id);
        $stitching->delete();
        return redirect()->route('atribute-stitching.index')->with('success','Stitching deleted successfully');
    }
}
