<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\User;
use Validator;

#use Maklad\Permission\Models\Report;
//use Maklad\Permission\Models\Permission;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::all();
        return view('admin.reports.index',compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        
        return view('admin.reports.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        
        $validator = Validator::make($request->all(), ['name' => 'required|unique:reports','url' => 'required:reports'])->validate();
        $report = Report::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'url'=>$request->url,
            'category' => $request->category,
            'active'=>$request->active
        ]);

        session()->flash('status', 'Report created successfully!');
        return redirect()->route('reports.index')->withMessage('Report Created');
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
    public function edit(Request $request,$id)
    {
         $report = Report::find($id);
         return view('admin.reports.edit',compact(['report']));
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
        
        $report = Report::find($id);
        $validator = Validator::make($request->all(), ['name' => 'required:reports','url' => 'required:reports'])->validate();
        $report->name = $request->name;
        $report->description = $request->description;
        $report->url = $request->url;
        $report->category = $request->category;
        $report->active = $request->active;
        $report->save();
        
        session()->flash('status', 'Report updated successfully!');
        return redirect()->route('reports.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $report = Report::find($id)->delete();
        session()->flash('status', 'Report deleted successfully!');
        return redirect()->route('reports.index');
    }
}