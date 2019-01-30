<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\JurisdictionType;
use App\Organisation;
use App\Location;
use Illuminate\Support\Facades\DB;
use Auth;
use Redirect;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtaining Organisation id of logged in user
        $orgId = Auth::user()->org_id;
        $organisation=Organisation::find($orgId);
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

        $locations = Location::all();

        return view('admin.locations.location_index',compact('locations','orgId','modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Obtaining Organisation id of logged in user
        $orgId = Auth::user()->org_id;
        $organisation=Organisation::find($orgId);
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

        $jurisdictions= JurisdictionType::all();

        return view('admin.locations.create_location',compact('jurisdictions','orgId','modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        // $request contains _token, jurisdictionTypeId, vlaues of locations: location0,location1,location2,level0_location0, jurisdictionTypes e.g. state,unit, cluster, noOfJurisdictionTypes
        
        // Obtaining Organisation id of logged in user
        $orgId = Auth::user()->org_id;
        $organisation=Organisation::find($orgId);
        $dbName=$organisation->name.'_'.$orgId;
        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);

        // Converting the string $request->jurisdictionTypes to an array of substrings using delimiter ','
        $jurisdictionTypes = explode(',',$request->jurisdictionTypes);

        $location = new Location;        
        $location->jurisdiction_type_id = $request->jurisdictionTypeId;

        // To create a collection of levels, e.g. { state:Goa, district:North Goa, taluka:Tiswadi }
        $arr = [];

        for($j = 0; $j<=$request->noOfJurisdictionTypes; $j++)
        {
            $i = 0;
        foreach($jurisdictionTypes as $type)
        {
            $level = "level".$j."_location".$i;
            // e.g. $arr['state'] = 'Goa'
            $arr[$j][$type] = $request->$level;           
            $i = $i+1;
        }
        }

        // Converting $arr to string
        $location->level = json_encode($arr);

        $location->save();

        session()->flash('status', 'Location was created!');
        return redirect()->route('locations.index',['orgId' => $orgId]);
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
    public function edit()
    {
        //Breaks up url into an array of substrings using delimiter '/'
        $uri = explode("/",$_SERVER['REQUEST_URI']);
        // $orgId = $uri[1];
        $locationId = $uri[3];

        // Obtaining Organisation id of logged in user
        $orgId = Auth::user()->org_id;
        $organisation=Organisation::find($orgId);
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

        $jurisdictions= JurisdictionType::all();

        $location = Location::find($locationId);

        // Converting $location->level from string to object
        $location->level = json_decode($location->level);
        
        return view('admin.locations.edit',compact('jurisdictions','location','orgId','modules'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //Breaks up url into an array of substrings using delimiter '/'
        $uri = explode("/",$_SERVER['REQUEST_URI']);
        $locationId = $uri[3];

        // $request contains _method: PUT, _token, jurisdictionTypeId, values of locations: location0,location1,location2, jurisdictionTypes e.g. state,unit,cluster
        
        // Obtaining Organisation id of logged in user
        $orgId = Auth::user()->org_id;
        $organisation=Organisation::find($orgId);
        $dbName=$organisation->name.'_'.$orgId;
        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);

        // Converting the string $request->jurisdictionTypes to an array of substrings using delimiter ','
        $jurisdictionTypes = explode(',',$request->jurisdictionTypes);
        
        $location = Location::find($locationId);        
        $location->jurisdiction_type_id = $request->jurisdictionTypeId;

        // To create a collection of levels, e.g. { state:Goa, district:North Goa, taluka:Tiswadi }
        $arr = [];

        for($j = 0; $j<$request->noOfJurisdictionTypes; $j++)
        {
            $i = 0;
        foreach($jurisdictionTypes as $type)
        {
            $level = "level".$j."_location".$i;
            // e.g. $arr['state'] = 'Goa'
            $arr[$j][$type] = $request->$level;           
            $i = $i+1;
        }       
        }

        // Converting $arr to string
        $location->level = json_encode($arr);
        $location->save();

        session()->flash('status', 'Location was edited!');
        return redirect()->route('locations.index',['orgId' => $orgId]);   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Breaks up url into an array of substrings using delimiter '/'
        $uri = explode("/",$_SERVER['REQUEST_URI']);
        // $orgId = $uri[1];
        $locationId = $uri[3];
        // Obtaining Organisation id of logged in user
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

        Location::find($locationId)->delete();
        
        // Redirects back to index page i.e. the listing of locations
        return Redirect::back()->withMessage('Location Deleted');     
    }
}
