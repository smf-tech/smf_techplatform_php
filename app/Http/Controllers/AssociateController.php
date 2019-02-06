<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Associate;
use Redirect;

class AssociateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        list($orgId, $dbName) = $this->setDatabaseConfig();
        DB::setDefaultConnection($dbName);

        $modules= DB::collection('modules')->get();
        $associates = Associate::all();
        return view('admin.associates.associates_index',compact('associates','orgId','modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        list($orgId, $dbName) = $this->setDatabaseConfig();
        DB::setDefaultConnection($dbName);

        $modules= DB::collection('modules')->get();

        return view('admin.associates.create_associate',compact('orgId','modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        list($orgId, $dbName) = $this->setDatabaseConfig();
        DB::setDefaultConnection($dbName);

        $data = $request->except(['_token']); 
        Associate::create($data);

        return redirect()->route('associates.index',['orgId' => $orgId]);
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
    public function edit()
    {
        list($orgId, $dbName) = $this->setDatabaseConfig();
        DB::setDefaultConnection($dbName);

        $uri = explode("/",$_SERVER['REQUEST_URI']);
        $associateId = $uri[3];
        $associate = Associate::find($associateId);

        $modules= DB::collection('modules')->get();

        return view('admin.associates.edit',compact('orgId','modules','associate'));
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
        list($orgId, $dbName) = $this->setDatabaseConfig();
        DB::setDefaultConnection($dbName);

        $uri = explode("/",$_SERVER['REQUEST_URI']);
        $associateId = $uri[3];

        Associate::where('_id',$associateId)->update(['name'=>$request->name,'type'=>$request->type,'contact_person'=>$request->contact_person,'contact_number'=>$request->contact_number]);

        return redirect()->route('associates.index',['orgId' => $orgId]);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        
        list($orgId, $dbName) = $this->setDatabaseConfig();
        DB::setDefaultConnection($dbName);

        $uri = explode("/",$_SERVER['REQUEST_URI']);
        $associateId = $uri[3];
        Associate::find($associateId)->delete();

        return Redirect::back()->withMessage('Associate Deleted');                
    }
}
