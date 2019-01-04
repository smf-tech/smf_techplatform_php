<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Microservice;
use App\Organisation;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use Redirect;

class MicroservicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orgId = Auth::user()->org_id;
        $organisation=Organisation::find($orgId);
        $dbName=$organisation->name.'_'.$orgId;

        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);
        $modules= DB::collection('modules')->get();

        $microservices = Microservice::paginate(5);
        return view('admin.microservices.microservices_index',compact('orgId','modules','microservices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $orgId = Auth::user()->org_id;
        $organisation=Organisation::find($orgId);
        $dbName=$organisation->name.'_'.$orgId;

        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);
        $modules= DB::collection('modules')->get();

        return view('admin.microservices.create_microservice',compact('orgId','modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'unique:microservices',
        ]);

        if ($validator->fails()) {            
            return Redirect::back()->withErrors(['Microservice already exists']);
        }
        
        $orgId = Auth::user()->org_id;
        $organisation=Organisation::find($orgId);
        $dbName=$organisation->name.'_'.$orgId;

        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);
        // return $request;
            $microservice = new Microservice;
            $microservice->name = $request->name;
            $microservice->description = $request->description;
            $microservice->base_url = $request->url;
            $microservice->route = $request->route;
            $microservice->is_active = (bool)$request->active;
            $microservice->save();
       
        session()->flash('status', 'Microservice was created!');
        return redirect()->route('microservice.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($microservice_id)
    {
        $orgId = Auth::user()->org_id;
        $organisation=Organisation::find($orgId);
        $dbName=$organisation->name.'_'.$orgId;

        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);
        $modules= DB::collection('modules')->get();
        $microservice = Microservice::find($microservice_id);

        return view('admin.microservices.edit',compact('orgId','modules','microservice'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $microservice_id)
    {
        $orgId = Auth::user()->org_id;
        $organisation=Organisation::find($orgId);
        $dbName=$organisation->name.'_'.$orgId;

        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);

        $microservice = Microservice::find($microservice_id);

        $microservice->name = $request->name;
            $microservice->description = $request->description;
            $microservice->base_url = $request->url;
            $microservice->route = $request->route;
            $microservice->is_active = (bool)$request->active;
            $microservice->save();
        
        session()->flash('status', 'Microservice was edited!');
        return redirect()->route('microservice.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($microservice_id)
    {
        $orgId = Auth::user()->org_id;
        $organisation=Organisation::find($orgId);
        $dbName=$organisation->name.'_'.$orgId;

        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);

        Microservice::find($microservice_id)->delete();
        return redirect()->route('microservice.index')->withSuccessMessage('State Deleted');
    }
}
