<?php

namespace App\Http\Controllers;

use App\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $modules = Module::all();
        return view('admin.modules.index', compact('orgId', 'modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        return view('admin.modules.create', compact('orgId'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        Module::create($request->validate([
            'name' => 'required|unique:modules'
        ]));
        return redirect()->route(
                    'modules.index',
                    ['orgId' => $orgId]
                )->with('status', 'Module has been created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $orgId
     * @param string $module
     * @return \Illuminate\Http\Response
     */
    public function edit($orgId, $module)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase($orgId);

        $module = Module::find($module);
        return view('admin.modules.edit', compact('orgId', 'module'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $orgId
     * @param  string  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $orgId, $module)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase($orgId);

        Module::find($module)->update($request->validate(['name' => 'required']));
        return redirect()->route(
                    'modules.index',
                    ['orgId' => $orgId]
                )->with('status', 'Module has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $orgId
     * @param  \App\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy($orgId, $module)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase($orgId);

        Module::find($module)->delete();
        return back()->with('status', 'Module has been deleted successfully.');
    }
}
