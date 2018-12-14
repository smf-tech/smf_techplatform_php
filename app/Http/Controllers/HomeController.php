<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maklad\Permission\Models\Role;
use Maklad\Permission\Models\Permission;
use App\Organisation;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
       
        $id = Auth::id();
        $user =Auth::user();
        if($user->hasRole('ROOTORGADMIN')){
            return view('home');
        }   
        else 
        {               

            $orgId=$user->org_id;
            $organisation=Organisation::find($orgId);
            $dbName=$organisation->name.'_'.$organisation->id;

            \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
                'driver'    => 'mongodb',
                'host'      => '127.0.0.1',
                'database'  => $dbName,
                'username'  => '',
                'password'  => '',  
            ));

           
            DB::setDefaultConnection($dbName); 

            $modules = DB::collection('modules')->get();      
            return view('layouts.userBased',compact(['orgId','modules']));

        }
      
    }
}
