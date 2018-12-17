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

class OrganisationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
        $orgs=Organisation::where('id','<>','1')->get();
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
        $dbName=$org->name.'_'.$org->id;
        /*\Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => 'root',
            'password'  => '',  
        ));
        #DB::setDefaultConnection($dbName); 
        */
       try{
        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName); 
      

        }
        catch(QueryException  $e){
            var_dump($e);
            exit;
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
    
        return redirect()->route('organisation.index')->withMessage('Oganisation Created');
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
    return view('admin.Projects.projects_index',compact('projects'));
}
public function getCategories()
{
    
    $organisation_id = Auth::user()->org_id;

    $projects = Organisation::find($organisation_id);

    $dbName = $projects->name.'_'.$organisation_id;
    // return $dbName;
    \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
        'driver'    => 'mongodb',
        'host'      => '127.0.0.1',
        'database'  => $dbName,
        'username'  => '',
        'password'  => '',  
    ));
   
    DB::setDefaultConnection($dbName); 

    $projects = DB::collection('categories')->get(); 
    // $projects = Project::all();
    // return $projects[0]['_id'];
    // return json_decode($projects[0])->name;
    // foreach($projects[0] as $key=>$value)
    // {
    //     echo $value;
    // }
    // return null;
    return view('admin.Categories.categories_index',compact('projects'));

// foreach ($projects as $project) 
// {
//     echo $project->name;
// }
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
        DB::table('organisations')->where('_id',$id)->delete();
        return redirect()->route('organisation.index')->withMessage('Oganisation Deleted');
    }
}
