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
        list($orgId, $dbName) = $this->connectTenantDatabase();
        $categories=Category::all();

        return view('admin.categories.categories_index',compact('categories','orgId'));
        
    }

    public function create()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
		$locale = config('locale');
        return view('admin.categories.create_category',compact('orgId', 'locale'));
    }

    public function store(Request $request)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
		$this->validate(
				$request,
				[
					'name.default' => 'required|unique:categories,name.default'
				],
				$this->messages()
		);

        $category = new Category;
        $category->name = $request->name;
        $category->type = $request->categoryType;
        $category->save();

        return redirect()->route('category.index')->withMessage('Category Created');
    }

    public function edit($category_id)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
		$locale = config('locale');
        $category = Category::find($category_id);

       return view('admin.categories.edit',compact('orgId', 'locale', 'category'));
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
        list($orgId, $dbName) = $this->connectTenantDatabase();
		$this->validate(
				$request,
				[
					'name.default' => 'required'
				],
				$this->messages()
		);
        $category = Category::find($category_id);
        $category->name=$request->name;
        $category->type = $request->categoryType;
        $category->save();

        return redirect()->route('category.index')->withMessage('Category Updated');
    }

    public function destroy($id)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();
        Category::find($id)->delete();

        return Redirect::back()->withMessage('Category Deleted');
    }

	public function messages()
	{
		return [
			'name.default.required' => 'English locale name is required.',
			'name.default.unique' => 'English locale name has already been taken.'
		];
	}
}
