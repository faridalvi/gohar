<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeasonController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:season-list', ['only' => ['index']]);
        $this->middleware('permission:season-create', ['only' => ['create','store']]);
        $this->middleware('permission:season-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:season-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.season.index');
    }
    public function getSeasons(Request $request){
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
        $totalRecords = Season::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Season::select('count(*) as allcount')->where(function ($q) use ($searchValue){
            $q->where('name', 'like', '%' .$searchValue . '%');
        })->count();
        // Fetch records
        $records = Season::orderBy($columnName,$columnSortOrder)
            ->where(function ($q) use ($searchValue){
                $q->where('name', 'like', '%' .$searchValue . '%');
            })
            ->select('seasons.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach($records as $record){
            $id = $record->id;
            $name = $record->name;
            $slug = $record->slug;
            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "slug" => $slug,
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
        return view('admin.season.create');
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
            'name' => 'required|unique:seasons,name',
            'slug' => 'unique:seasons,slug',
        ]);
        $userId = Auth::user()->id;
        $season  = new Season();
        $season->name = $request->name;
        $season->slug = $this->createSlug($request->name);
        $season->created_by = $userId;
        $season->updated_by = $userId;
        $saved = $season->save();
        if (!empty($saved)){
            return redirect(route('season.index'))->with('message','Season created successfully');
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
        $season = Season::find($id);
        return view('admin.season.edit',compact('season'));
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
            'name' => 'required|unique:seasons,name,'.$id,
        ]);
        $userId = Auth::user()->id;
        $season  = Season::find($id);
        $season->name = $request->name;
        $season->updated_by = $userId;
        $saved = $season->save();
        if (!empty($saved)){
            return redirect(route('season.index'))->with('message','Season Updated successfully');
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
        $season = Season::find($id);
        if ($season->product->count() > 0){
            return redirect(route('season.index'))->with('warning','Please Delete its Product First');
        }
        $season->delete();
        return redirect()->route('season.index')->with('message','Season deleted successfully');
    }
    //Unique Slug
    public function createSlug($title, $id = 0)
    {
        $slug = str_slug($title);
        $allSlugs = $this->getRelatedSlugs($slug, $id);
        if (! $allSlugs->contains('slug', $slug)){
            return $slug;
        }

        $i = 1;
        $is_contain = true;
        do {
            $newSlug = $slug . '-' . $i;
            if (!$allSlugs->contains('slug', $newSlug)) {
                $is_contain = false;
                return $newSlug;
            }
            $i++;
        } while ($is_contain);
    }
    protected function getRelatedSlugs($slug, $id = 0)
    {
        return Season::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }
}
