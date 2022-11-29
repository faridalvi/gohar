<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgeGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgeGroupController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:age-group-list', ['only' => ['index']]);
        $this->middleware('permission:age-group-create', ['only' => ['create','store']]);
        $this->middleware('permission:age-group-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:age-group-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.age_group.index');
    }
    public function getAgeGroups(Request $request){
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
        $totalRecords = AgeGroup::select('count(*) as allcount')->count();
        $totalRecordswithFilter = AgeGroup::select('count(*) as allcount')->where(function ($q) use ($searchValue){
            $q->where('name', 'like', '%' .$searchValue . '%');
        })->count();
        // Fetch records
        $records = AgeGroup::orderBy($columnName,$columnSortOrder)
            ->where(function ($q) use ($searchValue){
                $q->where('name', 'like', '%' .$searchValue . '%');
            })
            ->select('age_groups.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach($records as $record){
            $id = $record->id;
            $name = $record->name;
            $slug = $record->slug;
            $ageBetween = $record->age_between;
            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "slug" => $slug,
                "age_between" => $ageBetween,
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
        return view('admin.age_group.create');
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
            'name' => 'required|unique:age_groups,name',
            'slug' => 'unique:age_groups,slug',
            'age_between' => 'required',
        ]);
        $userId = Auth::user()->id;
        $ageGroup  = new AgeGroup();
        $ageGroup->name = $request->name;
        $ageGroup->age_between = $request->age_between;
        $ageGroup->slug = $this->createSlug($request->name);
        $ageGroup->created_by = $userId;
        $ageGroup->updated_by = $userId;
        $saved = $ageGroup->save();
        if (!empty($saved)){
            return redirect(route('age-group.index'))->with('message','Age Group created successfully');
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
        $ageGroup = AgeGroup::find($id);
        return view('admin.age_group.edit',compact('ageGroup'));
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
            'name' => 'required|unique:age_groups,name,'.$id,
            'age_between'=>'required'
        ]);
        $userId = Auth::user()->id;
        $ageGroup  = AgeGroup::find($id);
        $ageGroup->name = $request->name;
        $ageGroup->age_between = $request->age_between;
        $ageGroup->updated_by = $userId;
        $saved = $ageGroup->save();
        if (!empty($saved)){
            return redirect(route('age-group.index'))->with('message','Age Group Updated successfully');
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
        $ageGroup = AgeGroup::find($id);
        $ageGroup->delete();
        return redirect()->route('age-group.index')->with('success','Age Group deleted successfully');
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
        return AgeGroup::select('slug')->where('slug', 'like', $slug.'%')
            ->where('id', '<>', $id)
            ->get();
    }
}
