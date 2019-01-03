<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entity;
use App\Organisation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Validator;
use Redirect;
use Auth;

class EntityController extends Controller
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

        $entities=Entity::all();
        return view('admin.Entities.entity_index',compact('entities','orgId','modules'));
        
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

        return view('admin.Entities.create_entity',compact('orgId','modules'));
      
    }

    public function store(Request $request)
    {  
        $validator = Validator::make($request->all(), [
            'Name' => 'unique:entities,name',
        ]);

        if ($validator->fails()) 
        {
            return Redirect::back()->withErrors(['Entity already exists']);
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
      
                Schema::connection($dbName)->create('entity_'.$request->entityName, function($table)
        {
            $table->increments('id');
            $table->string('User ID');
            $table->timestamps();
       });
       
       $entity = new Entity;
        $entity->Name = $request->entityName;
        $entity->display_name = $request->displayName;
        $entity->save();

        return redirect()->route('entity.index')->withMessage('Entity Created');
    }
    public function edit($entity_id)
    {
        // return Entity::find($entity_id);
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
        $entity = Entity::find($entity_id);
        // return $entity;
       return view('admin.Entities.edit',compact('orgId','modules','entity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $entity_id)
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

        $entity = Entity::find($entity_id);
        $entity->Name=$request->Name;
        $entity->display_name=$request->display_name;       
        $entity->save();

        return redirect()->route('entity.index')->withMessage('Entity Updated');
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

        $entity = Entity::find($id);
        // return $entity->Name;
        Schema::drop('entity_'.$entity->Name);   
        $entity->delete();
        return Redirect::back()->withMessage('Entity Deleted');   
    }
}
