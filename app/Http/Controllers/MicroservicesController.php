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
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $microservices = Microservice::paginate(5);
        return view('admin.microservices.microservices_index',compact('orgId', 'microservices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        return view('admin.microservices.create_microservice',compact('orgId'));
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
        
        list($orgId, $dbName) = $this->connectTenantDatabase();
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
        list($orgId, $dbName) = $this->connectTenantDatabase();
        $microservice = Microservice::find($microservice_id);

        return view('admin.microservices.edit',compact('orgId', 'microservice'));
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
        list($orgId, $dbName) = $this->connectTenantDatabase();

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
        list($orgId, $dbName) = $this->connectTenantDatabase();

        Microservice::find($microservice_id)->delete();
        return redirect()->route('microservice.index')->withSuccessMessage('State Deleted');
    }
}
