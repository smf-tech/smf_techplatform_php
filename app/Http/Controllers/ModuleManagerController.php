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
            $modules =    DB::select('select * from modules ');      
            $module_name =    DB::select('select name from modules where id ='.$module_id); 
            $module_content=  DB::select('select * from '.$module_name[0]->name.' limit 1') ;
            //get the structure of the table 
            $structure=DB::select('SHOW  COLUMNS FROM '.$module_name[0]->name);
             foreach ($structure as $x){
                $fields[] = $x->Field;
              }
            
            return view('user.moduleViewer',compact(['module_content','orgId','modules','fields','module_name']));     
           
    }
}
