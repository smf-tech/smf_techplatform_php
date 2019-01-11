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

class ProjectController extends Controller
{
    public function index()
    {    
        // $uri = explode("/",$_SERVER['REQUEST_URI']);
        $orgId = Auth::user()->org_id;
        $organisation=Organisation::find($orgId);
        // $orgId=$organisation->id;
        $dbName=$organisation->name.'_'.$orgId;
        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);
        $modules= DB::collection('modules')->get();

        $projects=Project::all();
        return view('admin.projects.projects_index',compact('projects','orgId','modules'));
        
    }

    public function create()
    {
        $uri = explode("/",$_SERVER['REQUEST_URI']);

        $organisation=Organisation::find($uri[1]);
        $orgId=$organisation->id;
        $dbName=$organisation->name.'_'.$organisation->id;

        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);
        $modules= DB::collection('modules')->get();

        return view('admin.projects.create_project',compact('orgId','modules'));
      
    }

    public function store(Request $request)
    {  
        $validator = Validator::make($request->all(), [
            'Name' => 'unique:projects,name',
        ]);

        if ($validator->fails()) 
        {
            return Redirect::back()->withErrors(['Project already exists']);
        }
        
        $organisation_id = Auth::user()->org_id;
        $org = Organisation::find($organisation_id);
        $dbName=$org->name.'_'.$organisation_id;
        
        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName); 
      
        $project = new Project;
        $project->name = $request->projectName;
        $project->save();

        return redirect()->route('project.index')->withMessage('project Created');
    }
    public function edit($project_id)
    {
        $orgId = Auth::user()->org_id;
        $organisation = Organisation::find($orgId);
        $dbName=$organisation->name.'_'.$orgId;

        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);

        $modules= DB::collection('modules')->get();
        $project = project::find($project_id);
        
       return view('admin.projects.edit',compact('orgId','modules','project'));
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
        $organisation_id = Auth::user()->org_id;
        $organisation = Organisation::find($organisation_id);
        $dbName=$organisation->name.'_'.$organisation_id;

        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);

        $project = Project::find($project_id);
        $project->name=$request->Name;
        $project->save();

        return redirect()->route('project.index')->withMessage('Project Updated');
    }

    public function destroy($id)
    {
        $organisation_id = Auth::user()->org_id;
        $org = Organisation::find($organisation_id);

        $dbName=$org->name.'_'.$organisation_id;
        
        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName); 

        Project::find($id)->delete();
        
        return Redirect::back()->withMessage('project Deleted');   
    }
}
