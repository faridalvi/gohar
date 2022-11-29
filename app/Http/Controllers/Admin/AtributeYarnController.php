<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AtributeYarn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AtributeYarnController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:atribute-yarn-list', ['only' => ['index']]);
        $this->middleware('permission:atribute-yarn-create', ['only' => ['create','store']]);
        $this->middleware('permission:atribute-yarn-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:atribute-yarn-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.yarn.index');
    }
    public function getAtributeYarn(Request $request){
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
        $totalRecords = AtributeYarn::select('count(*) as allcount')->count();
        $totalRecordswithFilter = AtributeYarn::select('count(*) as allcount')->where(function ($q) use ($searchValue){
            $q->where('name', 'like', '%' .$searchValue . '%')
                ->where('type', 'like', '%' .$searchValue . '%')
                ->where('description', 'like', '%' .$searchValue . '%');
        })->count();
        // Fetch records
        $records = AtributeYarn::orderBy($columnName,$columnSortOrder)
            ->where(function ($q) use ($searchValue){
                $q->where('name', 'like', '%' .$searchValue . '%')
                    ->where('type', 'like', '%' .$searchValue . '%')
                    ->where('description', 'like', '%' .$searchValue . '%');
            })
            ->select('atribute_yarns.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach($records as $record){
            $id = $record->id;
            $name = $record->name;
            $type = $record->type;
            $description = $record->description;
            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "type" => $type,
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
        return view('admin.yarn.create');
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
            'name' => 'required|unique:atribute_yarns,name',
            'type' => 'required',
            'description' => 'required',
        ]);
        $userId = Auth::user()->id;
        $yarn  = new AtributeYarn();
        $yarn->name = $request->name;
        $yarn->type = $request->type;
        $yarn->description = $request->description;
        $yarn->created_by = $userId;
        $yarn->updated_by = $userId;
        $saved = $yarn->save();
        if (!empty($saved)){
            return redirect(route('atribute-yarn.index'))->with('message','Yarn created successfully');
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
        $yarn = AtributeYarn::find($id);
        return view('admin.yarn.edit',compact('yarn'));
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
            'name' => 'required|unique:atribute_yarns,name,'.$id,
            'type' => 'required',
            'description' => 'required',
        ]);
        $userId = Auth::user()->id;
        $yarn  = AtributeYarn::find($id);
        $yarn->name = $request->name;
        $yarn->type = $request->type;
        $yarn->description = $request->description;
        $yarn->updated_by = $userId;
        $saved = $yarn->save();
        if (!empty($saved)){
            return redirect(route('atribute-yarn.index'))->with('message','Yarn Updated successfully');
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
        $yarn = AtributeYarn::find($id);
        $yarn->delete();
        return redirect()->route('atribute-yarn.index')->with('success','Yarn deleted successfully');
    }
}
