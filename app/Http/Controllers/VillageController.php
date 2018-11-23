<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Village;
use App\Cluster;
use App\Taluka;
use App\District;
use App\State;

class VillageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vil = Village::all();
        return view('admin.villages.villages_index',compact('vil'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        $states = State::all();
        $districts = District::all();
        $talukas = Taluka::all();
        $clusters = Cluster::all();

        return view('admin.villages.create_village',compact('states','districts','talukas','clusters'));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $vil = new Village;
        $vil->Name = $request->villageName;
        $vil->state_id = $request->state_id;
        $vil->district_id = $request->District;
        $vil->taluka_id = $request->Taluka;
       
        if($request->Cluster){
            $vil->cluster_id = $request->Cluster;
         }
            $vil->save();

        return redirect()->route('village.index')->withMessage('Village Created');
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
        $vil = Village::find($id);
        $states = State::all();
        $districts = District::all();
        $talukas = Taluka::all();        
        $clusters = Cluster::all();

        return view('admin.villages.edit',compact('vil','states','districts','talukas','clusters'));
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
        $vil=Village::find($id);
        // $dis->id=$request->id;
        $vil->villageName=$request->villageName;
        $vil->state_id = $request->state_id;
        $vil->district_id = $request->district_id;
        $vil->taluka_id = $request->taluka_id;
        $vil->cluster_id = $request->cluster_id;
        $vil->save();

        return redirect()->route('village.index')->withMessage('Village Edited');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vil=Village::find($id)->delete();
        return redirect()->route('village.index')->withMessage('Village Deleted');                
    }
}
