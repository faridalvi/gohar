<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AtributeProcessing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AtributeProcessingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:atribute-processing-list', ['only' => ['index']]);
        $this->middleware('permission:atribute-processing-create', ['only' => ['create','store']]);
        $this->middleware('permission:atribute-processing-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:atribute-processing-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.processing.index');
    }
    public function getAtributeProcessing(Request $request){
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
        $totalRecords = AtributeProcessing::select('count(*) as allcount')->count();
        $totalRecordswithFilter = AtributeProcessing::select('count(*) as allcount')->where(function ($q) use ($searchValue){
            $q->where('name', 'like', '%' .$searchValue . '%')
                ->where('description', 'like', '%' .$searchValue . '%');
        })->count();
        // Fetch records
        $records = AtributeProcessing::orderBy($columnName,$columnSortOrder)
            ->where(function ($q) use ($searchValue){
                $q->where('name', 'like', '%' .$searchValue . '%')
                    ->where('description', 'like', '%' .$searchValue . '%');
            })
            ->select('atribute_processings.*')
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
        return view('admin.processing.create');
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
            'name' => 'required|unique:atribute_processings,name',
            'description' => 'required',
        ]);
        $userId = Auth::user()->id;
        $processing  = new AtributeProcessing();
        $processing->name = $request->name;
        $processing->description = $request->description;
        $processing->created_by = $userId;
        $processing->updated_by = $userId;
        $saved = $processing->save();
        if (!empty($saved)){
            return redirect(route('atribute-processing.index'))->with('message','Processing created successfully');
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
        $processing = AtributeProcessing::find($id);
        return view('admin.processing.edit',compact('processing'));
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
            'name' => 'required|unique:atribute_processings,name,'.$id,
            'description' => 'required',
        ]);
        $userId = Auth::user()->id;
        $processing  = AtributeProcessing::find($id);
        $processing->name = $request->name;
        $processing->description = $request->description;
        $processing->updated_by = $userId;
        $saved = $processing->save();
        if (!empty($saved)){
            return redirect(route('atribute-processing.index'))->with('message','Processing Updated successfully');
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
        $processing = AtributeProcessing::find($id);
        if ($processing->product->count() > 0){
            return redirect(route('atribute-processing.index'))->with('warning','Please Delete its Product First');
        }
        $processing->delete();
        return redirect()->route('atribute-processing.index')->with('message','Processing deleted successfully');
    }
}
