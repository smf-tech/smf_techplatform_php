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
        $modules = DB::collection('modules')->get();

        $projects = Project::all();
        return view('admin.projects.projects_index',compact('projects','orgId','modules'));
    }

    public function create()
    {
        list($orgId, $dbName) = $this->setDatabaseConfig();
        DB::setDefaultConnection($dbName);
        $modules= DB::collection('modules')->get();
        $jurisdictionTypes = JurisdictionType::all();
        return view('admin.projects.create_project',compact('orgId', 'modules', 'jurisdictionTypes'));
    }

    public function store(Request $request)
    {
        list($orgId, $dbName) = $this->setDatabaseConfig();
        DB::setDefaultConnection($dbName);
        $result = $request->validate([
            'name' => 'required|unique:projects',
            'jurisdictionType' => 'required'
        ]);
        // $project = new Project;
        // $project->name = $result['name'];
        // $project->jurisdiction_type_id = $result['jurisdictionType'];
        // $project->save();

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
        list($orgId, $dbName) = $this->setDatabaseConfig();
        DB::setDefaultConnection($dbName);

        $modules= DB::collection('modules')->get();
        $project = Project::find($project_id);
        $jurisdictionTypes = JurisdictionType::all();
        
       return view('admin.projects.edit',compact('orgId','modules','project', 'jurisdictionTypes'));
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
        list($orgId, $dbName) = $this->setDatabaseConfig();
        DB::setDefaultConnection($dbName);
        $result = $request->validate([
            'name' => 'required',
            'jurisdictionType' => 'required'
        ]);
        // $project = Project::find($project_id);
        // $project->name = $result['name'];
        // $project->jurisdiction_type_id = $result['jurisdictionType'];
        // $project->save();

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
        $organisation_id = Auth::user()->org_id;
        $org = Organisation::find($organisation_id);
        $user_id =  Auth::user()->id;
        DB::table('roles')->where('project_id',$id)->update(['project_id' => null]);
        //DB::table('roles')->whereIn('user_ids',$user_id)->where('project_id',$id)->delete();
        $dbName = $org->name.'_'.$organisation_id;
        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        
        DB::setDefaultConnection($dbName); 
        Project::find($id)->delete();
        return Redirect::back()->withMessage('Project Deleted');   
    }
}
