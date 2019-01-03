<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\District;
use App\State;
use Validator;
use Redirect;
use Illuminate\Validation\Rule;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dis = District::all();
        return view('admin.districts.districts_index',compact('dis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = State::all();
        return view('admin.districts.create_district',compact('states'));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $districts = District::where('Name',$request->districtName)->where('state_id',$request->state_id)->get();

        if(!$districts->isEmpty())
        {
            return Redirect::back()->withErrors(['District already exists']);
        }

        $dis = new District;
        $dis->Name = $request->districtName;
        $dis->state_id = $request->state_id;
        $dis->save();
        return redirect()->route('district.index')->withMessage('District Created');               
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
        $dis = District::find($id);
        $states = State::all();

        return view('admin.districts.edit',compact('dis','states'));
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
        $dis=District::find($id);
        $dis->districtName=$request->districtName;
        $dis->state_id=$request->state_id;
        $dis->save();

        return redirect()->route('district.index')->withMessage('District Edited');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dis=District::find($id)->delete();
        return redirect()->route('district.index')->withMessage('District Deleted');                
    }
}
