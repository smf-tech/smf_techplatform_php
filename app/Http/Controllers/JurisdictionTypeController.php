<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Jurisdiction;
use App\JurisdictionType;
use App\Organisation;

class JurisdictionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

//        $this->importDataIntoLocation();echo 'imported';exit;
        $modules= DB::collection('modules')->get();
        $jurisdictionTypes = JurisdictionType::all();

        return view('admin.jurisdiction-types.index', compact('orgId', 'modules', 'jurisdictionTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        list($orgId, $dbName) = $this->connectTenantDatabase();

        $modules = DB::collection('modules')->get();
        $jurisdictions = Jurisdiction::all()->unique('levelName', true);
        return view('admin.jurisdiction-types.create', compact('orgId', 'modules', 'jurisdictions'));
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

        JurisdictionType::create($request->validate([
            'jurisdictions' => 'required'
        ]));
        return redirect()->route(
                    'jurisdiction-types.index',
                    ['orgId' => $orgId]
                )->with('status', 'Jurisdiction Type has been created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $orgId
     * @param string $jurisdictionTypeId
     * @return \Illuminate\Http\Response
     */
    public function edit($orgId, $jurisdictionTypeId)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase($orgId);

        $modules = DB::collection('modules')->get();
        $jurisdictionType = JurisdictionType::where('_id', $jurisdictionTypeId)->first();
        $jurisdictions = Jurisdiction::all()->unique('levelName', true);
        return view('admin.jurisdiction-types.edit', compact('orgId', 'modules', 'jurisdictionType', 'jurisdictions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param string $orgId
     * @param string $jurisdictionTypeId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $orgId, $jurisdictionTypeId)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase($orgId);

        JurisdictionType::where('_id', $jurisdictionTypeId)->update($request->validate(['jurisdictions' => 'required']));
        return redirect()->route(
                    'jurisdiction-types.index',
                    ['orgId' => $orgId]
                )->with('status', 'Jurisdiction Type has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $orgId
     * @param string $jurisdictionTypeid
     * @return \Illuminate\Http\Response
     */
    public function destroy($orgId, $jurisdictionTypeId)
    {
        list($orgId, $dbName) = $this->connectTenantDatabase($orgId);

        JurisdictionType::where('_id', $jurisdictionTypeId)->delete();
        return back()->with('status', 'Jurisdiction Type has been deleted successfully.');
    }
}
