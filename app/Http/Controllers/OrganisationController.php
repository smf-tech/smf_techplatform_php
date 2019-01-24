<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organisation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\QueryException;
use Auth;
use App\Project;
use Jenssegers\Mongodb\Schema\Builder;
use Illuminate\Database\Schema\Builder as Build;
use Illuminate\Database\Connection;
use Maklad\Permission\Models\Role;
use Maklad\Permission\Models\Permission;

class OrganisationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        $orgs = Organisation::where('orgshow','<>',0)->get();
        return view('admin.organisations.organisation_index',compact('orgs'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.organisations.create_organisation');
      
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
        $dbName=$org->name.'_'.$org->id;
        
       try {
            \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
                'driver'    => 'mongodb',
                'host'      => '127.0.0.1',
                'database'  => $dbName,
                'username'  => '',
                'password'  => '',  
            ));
            DB::setDefaultConnection($dbName);
            Schema::connection($dbName)->create('jurisdictions', function($table) {
                $table->increments('id');
                $table->string('levelName');
                $table->timestamps();
            });
            Schema::connection($dbName)->create('jurisdictions_types', function($table) {
                $table->increments('id');
                $table->string('jurisdictions');
                $table->timestamps();
            });
            Schema::connection($dbName)->create('locations', function($table) {
                $table->increments('id');
                $table->string('name');
                $table->string('jurisdiction_type_id');
                $table->timestamps();
            });
            
        } catch(QueryException  $e) {
            DB::setDefaultConnection('mongodb');
            $this->destroy($org->id);
            return redirect()->route('organisation.index')->withMessage('Oganisation Not Created');
 
        }
        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName.'1', array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));

        Schema::connection($dbName.'1')->create('modules', function($table)
        {
            $table->increments('id');
            $table->string('name');
       });
       Schema::connection($dbName.'1')->create('surveys', function($table)
       {
            $table->increments('id');
            $table->string('name');
            $table->text('json');
            $table->integer('creator_id')->unsigned();
            $table->timestamps();
      });
      Schema::connection($dbName.'1')->create('survey_results', function($table)
      {
            $table->increments('id');
            $table->unsignedInteger('survey_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->text('json');
            $table->timestamps();
     });

     Schema::connection($dbName.'1')->create('projects', function($table)
      {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
     });

     Schema::connection($dbName.'1')->create('categories', function($table)
     {
           $table->increments('id');
           $table->string('name')->unique();
           $table->timestamps();
    });
    
    session()->flash('status', 'Oganisation was created!');
    return redirect()->route('organisation.index');
}

public function getProjects()
{    
    $organisation_id = Auth::user()->org_id;

    $projects = Organisation::find($organisation_id);

    $dbName = $projects->name.'_'.$organisation_id;
    \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
        'driver'    => 'mongodb',
        'host'      => '127.0.0.1',
        'database'  => $dbName,
        'username'  => '',
        'password'  => '',  
    ));
    DB::setDefaultConnection($dbName); 

    $projects = DB::collection('projects')->get(); 
    return view('admin.projects.projects_index',compact('projects'));
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
       return view('admin.organisations.edit',compact('org'));
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

        session()->flash('status', 'Oganisation was updated!');
        return redirect()->route('organisation.index');
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
        DB::table('organisations')->where('_id',$id)->delete();
        return redirect()->route('organisation.index')->withMessage('Oganisation Deleted');
    }

    public function orgroles(Request $request,$org_id)
    {
        $organisation=Organisation::find($org_id);
        $dbName=$organisation->name.'_'.$org_id;
        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);
        $modules= DB::collection('modules')->get();
        DB::setDefaultConnection('mongodb');
        $roles=Role::where('org_id', $org_id)->get();
        $orgId = $org_id;
        return view('admin.organisations.roles_index',compact('roles','modules','orgId'));
    }

    public function configureRole(Request $request,$org_id,$role_id){
        $organisation=Organisation::find($org_id);
        $role = Role::find($role_id);
        
        $dbName=$organisation->name.'_'.$org_id;
        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);
       
        $modules= DB::collection('modules')->get();
        $projects= DB::collection('projects')->get();
        $roleconfig = DB::collection('role_configs')->where('role_id', $role_id)->first();
        $role_projects = $role_default_modules = $role_onapprove_modules = $approver_role = array();
        if(isset($roleconfig)){
            $role_projects =  isset($roleconfig['projects'])?$roleconfig['projects']:[];
            $role_default_modules = isset($roleconfig['default_modules'])?$roleconfig['default_modules']:[];
            $role_onapprove_modules = isset($roleconfig['on_approve_modules'])?$roleconfig['on_approve_modules']:[];
            $approver_role = isset($roleconfig['approver_role'])?$roleconfig['approver_role']:[];       
        }     
        
        DB::setDefaultConnection('mongodb');
        $orgId = $org_id;
        $org_roles=DB::collection('roles')->where('org_id', $orgId)->where('_id','<>',$role_id)->get();
        return view('admin.organisations.role_access',compact('modules','orgId','role','projects','role_default_modules','role_projects','role_onapprove_modules','org_roles','approver_role'));
    }  

    public function updateroleconfig(Request $request,$role_id){
        $data = $request->post();
        $org_id = $data['org_id'];
        $organisation=Organisation::find($org_id);
        $dbName=$organisation->name.'_'.$org_id;
        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);
        $config_data = array('projects' => isset($data['assigned_projects'])?$data['assigned_projects']:[],
                            'default_modules' =>isset($data['default_modules'])?$data['default_modules']:[],
                            'on_approve_modules' =>isset($data['on_approve'])?$data['on_approve']:[],
                            'approver_role' =>isset($data['approver_role'])?$data['approver_role']:[],);
        DB::collection('role_configs')->where('role_id', $role_id)
                        ->update($config_data, ['upsert' => true]);                  
        return redirect()->route('roleconfig', ['orgId' => $org_id, 'role_id' => $role_id])->with('message', 'RoleConfig Updated Successfuly!!!');
    }      
}
