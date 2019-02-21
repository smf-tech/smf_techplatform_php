<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Organisation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Validator;
use Redirect;
use Auth;
use App\JurisdictionType;

class ProjectController extends Controller
{
    public function index()
    {    
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $projects = Project::all();
        return view('admin.projects.projects_index',compact('projects','orgId'));
    }

    public function create()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
        $jurisdictionTypes = JurisdictionType::all();
        return view('admin.projects.create_project',compact('orgId', 'jurisdictionTypes'));
    }

    public function store(Request $request)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
        $result = $request->validate([
            'name' => 'required|unique:projects',
            'jurisdictionType' => 'required'
        ]);

        $project = DB::collection('projects')->insert(
            [
            'name'=>$result['name'],
            'jurisdiction_type_id'=>$result['jurisdictionType']
            ]
        );

        return redirect()->route('project.index')->withMessage('project Created');
    }
    public function edit($project_id)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $project = Project::find($project_id);
        $jurisdictionTypes = JurisdictionType::all();
        
       return view('admin.projects.edit',compact('orgId', 'project', 'jurisdictionTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $project_id)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $result = $request->validate([
            'name' => 'required',
            'jurisdictionType' => 'required'
        ]);

        $project = DB::collection('projects')->where('_id',$project_id)->update(
            [
            'name'=>$result['name'],
            'jurisdiction_type_id'=>$result['jurisdictionType']
            ]
        );
        return redirect()->route('project.index')->withMessage('Project Updated');
    }

    public function destroy($id)
    {
        DB::table('roles')->where('project_id',$id)->update(['project_id' => null]);
        $this->connectTenantDatabase();
        Project::find($id)->delete();
        return Redirect::back()->withMessage('Project Deleted');
    }
}
