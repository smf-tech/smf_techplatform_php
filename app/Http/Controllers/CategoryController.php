<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Organisation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Validator;
use Redirect;
use Auth;

class CategoryController extends Controller
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

        $categories=Category::all();
        return view('admin.categories.categories_index',compact('categories','orgId','modules'));
        
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

        return view('admin.categories.create_category',compact('orgId','modules'));
      
    }

    public function store(Request $request)
    {  
        $validator = Validator::make($request->all(), [
            'Name' => 'unique:categories,name',
        ]);

        if ($validator->fails()) 
        {
            return Redirect::back()->withErrors(['Category already exists']);
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
      
        $category = new Category;
        $category->name = $request->categoryName;
        $category->save();       

        return redirect()->route('category.index')->withMessage('Category Created');
    }
    public function edit($category_id)
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
        $category = Category::find($category_id);

       return view('admin.categories.edit',compact('orgId','modules','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $category_id)
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

        $category = Category::find($category_id);
        $category->name=$request->Name;
        $category->save();

        return redirect()->route('categories.index')->withMessage('Category Updated');
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

        Category::find($id)->delete();
        
        return Redirect::back()->withMessage('Entity Deleted');   
    }
}
