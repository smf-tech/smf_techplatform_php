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
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $entities=Entity::all();
        return view('admin.entities.entity_index',compact('entities','orgId'));
    }

    public function create()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        return view('admin.entities.create_entity',compact('orgId'));
    }

    public function store(Request $request)
    {  
        $validator = Validator::make($request->all(), [
            'Name' => 'unique:entities,name',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors(['Entity already exists']);
        }

        list($orgId, $dbName) = $this->connectTenantDatabase();

        $entity = new Entity;
        $entity->Name = $request->entityName;
        $entity->display_name = $request->displayName;
        $entity->is_active = (bool)$request->active;
        $entity->save();

        Schema::connection($dbName)->create('entity_'.$entity->id, function($table)
        {
            $table->increments('id');
            $table->string('User ID');
            $table->timestamps();
       });

        return redirect()->route('entity.index')->withMessage('Entity Created');
    }
    public function edit($entity_id)
    {
        // return Entity::find($entity_id);
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $entity = Entity::find($entity_id);
       return view('admin.entities.edit',compact('orgId', 'entity'));
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
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $entity = Entity::find($entity_id);
        $entity->Name=$request->Name;
        $entity->display_name=$request->display_name;
        $entity->is_active = (bool)$request->active;
        $entity->save();

        return redirect()->route('entity.index')->withMessage('Entity Updated');
    }

    public function destroy($id)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $entity = Entity::find($id);
        Schema::drop('entity_'.$id);
        $entity->delete();
        return Redirect::back()->withMessage('Entity Deleted');
    }
}
