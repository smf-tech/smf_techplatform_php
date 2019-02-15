<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Jurisdiction;
use App\Project;
use App\Organisation;
use Illuminate\Support\Facades\DB;
use Validator;
use Redirect;
use Auth;


class JurisdictionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        $juris = Jurisdiction::all();
        return view('admin.jurisdictions.jurisdiction_index',compact('juris','orgId','modules'));
        //return view('admin.jurisdictions.jurisdiction_index',compact('juris'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        return view('admin.jurisdictions.create_jurisdiction', compact('orgId','modules') );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Jurisdiction $juris)
    {
        $organisation_id = Auth::user()->org_id;
        $org = Organisation::find($organisation_id);
        $dbName = $org->name.'_'.$organisation_id;
        
        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);
        
        $validator = Validator::make($request->all(), ['levelName' => 'required|unique:jurisdictions'])->validate();

        $juris = new Jurisdiction;
        $juris->levelName = $request->levelName;
        $juris->save();

        Schema::connection($dbName)->create($juris->levelName, function($table)
        {
            $table->increments('id');
            $table->string('name');            
            $table->timestamps();
       });

        session()->flash('status', 'Jurisdiction was created!');
        return redirect()->route('jurisdictions.index');
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

        $juris = Jurisdiction::find($id);
        return view('admin.jurisdictions.edit',compact('orgId','modules','juris'));

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
        $organisation_id = Auth::user()->org_id;
        $organisation = Organisation::find($organisation_id);
        $dbName = $organisation->name.'_'.$organisation_id;

        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);
        $validator = Validator::make($request->all(), ['levelName' => 'required'])->validate();
        $juris=Jurisdiction::find($id);
        $juris->id=$request->id;
        $juris->levelName=$request->levelName;
        $juris->save();

        session()->flash('status', 'Jurisdiction was edited!');
        return redirect()->route('jurisdictions.index');   
    }
    
    /**
     * Checks if jurisdiction to be deleted
     * is associated with jurisdiction type
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function checkJurisdictionTypeExist(Request $request)
    {
        $id = $request->delJurisId;
        list($orgId, $dbName) = $this->setDatabaseConfig();
        DB::setDefaultConnection($dbName);

        $juris = Jurisdiction::find($id);
        $jurisName = $juris->levelName;
        $jurisTypeName = DB::table('jurisdiction_types')->select('jurisdictions')
                         ->whereIn('jurisdictions', [$jurisName])->get();
        $flattened = $jurisTypeName->flatten();
        $flattened->forget(0);
        
        if (in_array($jurisName,$flattened->all())) {
            
            return json_encode(array(
                'success' => true,
            ));
            
        } else {
            
            return json_encode(array(
                'success' => false,
            ));
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        $juris = Jurisdiction::find($id)->delete();

        session()->flash('status', 'Jurisdiction deleted successfully!');
        return redirect()->route('jurisdictions.index');                
    }
}
