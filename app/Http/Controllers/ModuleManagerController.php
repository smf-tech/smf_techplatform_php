<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organisation;
use Illuminate\Support\Facades\DB;

class ModuleManagerController extends Controller
{
    public function getModuleData($org_id,$module_id){
            //form the db_Connection name
          
            $organisation=Organisation::find($org_id);
            $orgId=$org_id;
            $dbName=$organisation->name.'_'.$organisation->id;
            \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
                'driver'    => 'mysql',
                'host'      => '127.0.0.1',
                'database'  => $dbName,
                'username'  => 'root',
                'password'  => '',  
            )); 
            DB::setDefaultConnection($dbName); 
            $modules =    DB::collection('modules')->get();      
            $module_name =   DB::collection('modules')->where('_id',$module_id); 
            $module_content=  DB::collection($module_name[0]->name);
            //get the structure of the table 
            $structure=DB::collection('SHOW  COLUMNS FROM '.$module_name[0]->name);
             foreach ($structure as $x){
                $fields[] = $x->Field;
              }
            
            return view('user.moduleViewer',compact(['module_content','orgId','modules','fields','module_name']));     
           
    }
}
