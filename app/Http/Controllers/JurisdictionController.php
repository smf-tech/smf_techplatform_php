<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jurisdiction;
use Illuminate\Support\Facades\DB;

class JurisdictionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $juris = Jurisdiction::all();
        return view('admin.jurisdictions.jurisdiction_index',compact('juris'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.jurisdictions.create_jurisdiction');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $juris = new Jurisdiction;
        $juris->levelName = $request->levelName;
        $juris->save();
        return redirect()->route('jurisdiction.index')->withMessage('Jurisdiction Created');
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
        $juris = Jurisdiction::find($id);
        return view('admin.jurisdictions.edit',compact('juris'));

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
        $juris=Jurisdiction::find($id);
        $juris->id=$request->id;
        $juris->levelName=$request->levelName;
        $juris->save();

        return redirect()->route('jurisdiction.index')->withMessage('Jurisdiction Edited');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $juris=Jurisdiction::find($id)->delete();
        return redirect()->route('jurisdiction.index')->withMessage('Jurisdiction Deleted');                
    }
}
