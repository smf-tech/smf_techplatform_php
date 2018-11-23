<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organisation;
use Illuminate\Support\Facades\DB;
class orgManager extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.orgManager.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.orgManager.createModule');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $org=Organisation::find($request->orgId);
        $dbName=$org->name.'_'.$org->id;
     
        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => 'root',
            'password'  => '',  
        ));
        DB::connection($dbName)-> select('insert into modules (name) values("'. $request->mName .'" ) ' );
        return redirect()->route('orgManager.show',$org->id);
    }

  
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $org=Organisation::find($id);
        $dbName=$org->name.'_'.$org->id;
     
        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => 'root',
            'password'  => '',  
        ));
       $modules= DB::connection($dbName)-> select('select * from modules');
       return view('admin.orgManager.index',compact(['modules','id']));
    }

    public function addModule(){

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
