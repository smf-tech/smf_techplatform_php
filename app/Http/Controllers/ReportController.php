<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Report;
use App\User;
use Validator;

#use Maklad\Permission\Models\Report;
//use Maklad\Permission\Models\Permission;

class ReportController extends Controller
{
    public function index()
    {
        list($orgId, $dbName) = $this->setDatabaseConfig();
        DB::setDefaultConnection($dbName);
        $reports = Report::all();
        return view('admin.reports.index', compact('orgId', 'reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        list($orgId, $dbName) = $this->setDatabaseConfig();
        DB::setDefaultConnection($dbName);
        return view('admin.reports.create', compact('orgId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        list($orgId, $dbName) = $this->setDatabaseConfig();
        DB::setDefaultConnection($dbName);
        $validator = Validator::make($request->all(), ['name' => 'required|unique:reports','url' => 'required:reports'])->validate();
        $report = Report::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'url'=>$request->url,
            'category' => $request->category,
            'active'=>$request->active
        ]);

        session()->flash('status', 'Report created successfully!');
        return redirect()->route('reports.index', ['orgId' => $orgId])->withMessage('Report Created');
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
     * @param string $orgId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $orgId, $id)
    {
        list($orgId, $dbName) = $this->setDatabaseConfig($orgId);
        DB::setDefaultConnection($dbName);
        $report = Report::find($id);
        return view('admin.reports.edit',compact('report', 'orgId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $orgId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $orgId, $id)
    {  
        list($orgId, $dbName) = $this->setDatabaseConfig($orgId);
        DB::setDefaultConnection($dbName);
        $report = Report::find($id);
        $validator = Validator::make($request->all(), ['name' => 'required:reports','url' => 'required:reports'])->validate();
        $report->name = $request->name;
        $report->description = $request->description;
        $report->url = $request->url;
        $report->category = $request->category;
        $report->active = $request->active;
        $report->save();
        
        session()->flash('status', 'Report updated successfully!');
        return redirect()->route('reports.index', ['orgId' => $orgId]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $orgId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($orgId, $id)
    {
        list($orgId, $dbName) = $this->setDatabaseConfig($orgId);
        DB::setDefaultConnection($dbName);
        $report = Report::find($id)->delete();
        session()->flash('status', 'Report deleted successfully!');
        return redirect()->route('reports.index', ['orgId' => $orgId]);
    }
}