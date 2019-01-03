<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cluster;
use App\Taluka;
use App\District;
use App\State;
use App\Jurisdiction;
use App\StateJurisdiction;
use Validator;
use Redirect;

class ClusterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clu = Cluster::all();
        return view('admin.clusters.clusters_index',compact('clu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $levelId=Jurisdiction::where('levelName','Cluster')->first();
        
        $stateIds=StateJurisdiction::where('jurisdiction_id',$levelId->id)->get(['state_id']);
        $id=array();
        foreach($stateIds as $stateId){
            $id[]=$stateId->state_id;
        }
        
        $states=State::whereIn('_id',$id)->get();
        return view('admin.clusters.create_cluster',compact('states'));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clusters = Cluster::where('Name',$request->clusterName)->where('taluka_id',$request->Taluka)->get();

        if(!$clusters->isEmpty())
        {
        return Redirect::back()->withErrors(['Cluster already exists']);
        }
        $clu = new Cluster;
        $clu->Name = $request->clusterName;
        $clu->state_id = $request->state_id;
        $clu->district_id = $request->District;
        $clu->taluka_id = $request->Taluka;
        $clu->save();
        return redirect()->route('cluster.index')->withMessage('Cluster Created');        
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
        $clu = Cluster::find($id);
        $states = State::all();
        $districts = District::all();
        $talukas = Taluka::all();

        return view('admin.clusters.edit',compact('clu','states','districts','talukas'));
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
        $clu=Cluster::find($id);
        $clu->clusterName=$request->clusterName;
        $clu->state_id = $request->state_id;
        $clu->district_id = $request->district_id;
        $clu->taluka_id = $request->taluka_id;
        $clu->save();

        return redirect()->route('cluster.index')->withMessage('Cluster Edited');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $clu=Cluster::find($id)->delete();
        return redirect()->route('cluster.index')->withMessage('Cluster Deleted');                
    }
}
