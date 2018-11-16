<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\Jurisdiction;
use App\StateJurisdiction;
use Illuminate\Support\Facades\DB;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $states = State::paginate(5);
        return view('admin.states.state_index',compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jurisdiction=Jurisdiction::all();
        return view('admin.states.create_state',compact('jurisdiction'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $state=State::create($request->except(['jurisdiction','_token']));
        $level=1;
        foreach($request->levels as $key=>$value){
            
            $s = new StateJurisdiction;
            $s->state_id = $state->id;
            $s->jurisdiction_id = (integer)$value;
            $s->level=$level;
            $level++;
            $s->save();
        }
        return redirect()->route('state.index')->withMessage('State Created');
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

    public function getJurisdiction(Request $request){
      
        $result=Jurisdiction::whereNOTIn('levelName',$request->list)->get();
        return json_encode($result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $state=State::find($id);
        $jurisdiction=Jurisdiction::all();

        $state_jurisdictions=StateJurisdiction::where('state_id',$id)->get();
        return view('admin.states.edit',compact(['state','jurisdiction','state_jurisdictions']));
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
        $state=State::find($id);
        $state->id=$request->id;
        $state->stateName=$request->stateName;
        $state->save();

        if ($request->jurisdiction!=null)
        {
            $sj = StateJurisdiction::where('state_id',$state->id)->delete();

            foreach($request->jurisdiction as $key=>$value){

                $s = new StateJurisdiction;
                $s->state_id = $state->id;
                $s->jurisdiction_id = (integer)$value;
                $s->save();
            }
        }
        return redirect()->route('state.index')->withMessage('State Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $state=State::find($id);
        $state->delete();
        return redirect()->route('state.index')->withMessage('State Deleted');
    }
}
