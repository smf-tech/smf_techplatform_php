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
        list($orgId, $dbName) = $this->setDatabaseConfig();
        DB::setDefaultConnection($dbName);

        $modules= DB::collection('modules')->get();
        $categories=Category::all();

        return view('admin.categories.categories_index',compact('categories','orgId','modules'));
        
    }

    public function create()
    {
        list($orgId, $dbName) = $this->setDatabaseConfig();
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
        
        list($orgId, $dbName) = $this->setDatabaseConfig();
        DB::setDefaultConnection($dbName);
      
        $category = new Category;
        $category->name = $request->categoryName;
        $category->save();       

        return redirect()->route('category.index')->withMessage('Category Created');
    }
    public function edit($category_id)
    {
        list($orgId, $dbName) = $this->setDatabaseConfig();
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
        list($orgId, $dbName) = $this->setDatabaseConfig();
        DB::setDefaultConnection($dbName);

        $category = Category::find($category_id);
        $category->name=$request->Name;
        $category->save();

        return redirect()->route('category.index')->withMessage('Category Updated');
    }

    public function destroy($id)
    {
        list($orgId, $dbName) = $this->setDatabaseConfig();
        DB::setDefaultConnection($dbName);
        Category::find($id)->delete();
        
        return Redirect::back()->withMessage('Entity Deleted');   
    }
}
