<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organisation;
use Illuminate\Support\Facades\DB;

class OrganisationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orgs=Organisation::paginate(5);
        return view('admin.Organisation.organisation_index',compact('orgs'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.Organisation.create_organisation');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $org=Organisation::create($request->except(['_token']));
        return redirect()->route('organisation.index')->withMessage('Oganisation Created');

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
        $org=Organisation::find($id);
       return view('admin.Organisation.edit',compact('org'));
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
        $org=Organisation::find($id);
        $org->name=$request->name;
        $org->service=$request->service;
       
        $org->save();
        return redirect()->route('organisation.index')->withMessage('Oganisation Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   $org=Organisation::find($id);
        DB::table('roles')->where('org_id',$id)->delete();
        DB::table('organisations')->where('id',$id)->delete();
        return redirect()->route('organisation.index')->withMessage('Oganisation Deleted');
    }
}
