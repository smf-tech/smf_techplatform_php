<?php

namespace App\Http\Controllers;
use App\Survey;
use App\Organisation;
use App\Entity;
use App\Microservice;
use Maklad\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\SurveyResult;
use Illuminate\Http\Request;
use Auth;
use Redirect;

class SurveyController extends Controller
{

    public function saveSurveyForm(Request $request)
    {
        $r = json_decode($request->json,true);
        $k = null;

        foreach($r as $key=>$value)
        {
            if($key == 'title')
                $k = $value;
        }    
      
        //form the connection string to the DB
        $organisation=Organisation::find($request->orgId);
        $dbName=$organisation->name.'_'.$organisation->id;
        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);
       
        $id = DB::collection('surveys')->insertGetId(
            ['name'=>$k ,'json'=>$request->json,'creator_id'=> $request->creator_id,
            'active'=>$request->active,'editable'=>$request->editable,
            'multiple_entry'=>$request->multiple_entry,'assigned_roles'=>$request->assigned_roles,
            'category_id'=>$request->category_id,'project_id'=>$request->project_id,
            'microservice_id'=>$request->microservice_id,
            'entity_id'=>$request->entity_id]
        );

        foreach($id as $key=>$value)
            $survey_id = $value;

        return json_encode($survey_id);
     
    }
    public function setKeys()
    {
        $keys = array();

        //Breaks up url into an array of substrings using delimiter '/'
        $uri = explode("/",$_SERVER['REQUEST_URI']);
        $orgId = $uri[1];
        $survey_id = $uri[3];

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

        $modules= DB::collection('modules')->get();

        //Returns fields _id,json of survey having survey id=$survey_id
        $survey = Survey::where('_id','=',$survey_id)->get(['json']);   

        //Breaks up json string into an array of substrings using delimiter '"'
        $jsonValue = explode('"',$survey[0]->json);

        //Obtains length of $jsonValue
        $length = sizeof($jsonValue) - 1;

        $numberOfKeys = 0;

        while($length > 0)      //Starts from the end of the json string
        {
            if('name' == $jsonValue[$length])   //Gets all values in the json string where key==name
            {
                if(!preg_match('/page/',$jsonValue[$length+2])) //Excludes all values in the json string if it contains page
                {
                    $keys[] = $jsonValue[$length+2];       //$jsonValue[$length+2] contains the name of the question
                    $numberOfKeys++;                    
                }
            }
            if('pages' == $jsonValue[$length])      //will break out of loop if key==pages
                break;
            $length --;
        }

        $primaryKeySet = array();
        return view('admin.surveys.editKeys',compact('primaryKeySet','keys','numberOfKeys','orgId','modules','survey_id'));
    }
    public function editKeys()
    {
         //Breaks up url into an array of substrings using delimiter '/'
        $uri = explode("/",$_SERVER['REQUEST_URI']);

        $keys = array();
        
        $orgId = $uri[1];
        $survey_id = $uri[3];
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
        $modules= DB::collection('modules')->get();

         //Returns fields _id,primaryKeys,json of survey having survey id=$survey_id
        $survey = Survey::where('_id','=',$survey_id)->get(['form_keys','json']);

        //obtains only the primary keys from $survey as an array
        $primaryKeySet = $survey[0]->form_keys;

        //Breaks up json string into an array of substrings using delimiter '"'
        $jsonValue = explode('"',$survey[0]->json);

        //Obtains length of $jsonValue
        $length = sizeof($jsonValue) - 1;
        $numberOfKeys = 0;
       
        while($length > 0)  //Starts from the end of the json string
        {
            if('name' == $jsonValue[$length])   //Gets all values in the json string where key==name
            {
                if(!preg_match('/page/',$jsonValue[$length+2]))   //Excludes all values in the json string if it contains page           
                {
                    $keys[] = $jsonValue[$length+2];    //$jsonValue[$length+2] contains the name of the question
                    $numberOfKeys++;
                }
            }
            if('pages' == $jsonValue[$length])       //will break out of loop if key==pages
                break;
            $length --;
        }

            return view('admin.surveys.editKeys',compact('primaryKeySet','keys','numberOfKeys','orgId','modules','survey_id'));
    }

    public function storeKeys(Request $request)
    {
        $survey_id = $request->surveyID;

        //Returns $request->primaryKeys[]
        $primaryKeys = $request->except(['_token','surveyID']); 

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

        DB::collection('surveys')->where('_id',$survey_id)->update($primaryKeys);

        //Redirects to index function
        return redirect($organisation_id.'/forms');
    }
    public function sendResponse(Request $request)
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
       

        DB::collection('survey_results')->insert([ 'survey_id'=>$request->surveyId,'user_id'=>$request->userId,'json_response'=>$request->jsonString]);

        return null;
    }
    public function display(Request $request)
    {     $uri = explode("/",$_SERVER['REQUEST_URI']);
        
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

        $json = $request->json;
        $json=json_decode($json);
        $json=json_encode($json);
        $survey_id = $request->surveyID;

        return view('layouts.survey',compact('json','survey_id','orgId','modules'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //getOranisation
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

        $surveys=Survey::paginate(5);
       
        return view('admin.surveys.survey_index',compact('surveys','orgId','modules'));
    }
    public function viewResults(Request $request){
        $survey_id=$request->surveyID;
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
        $survey_results=SurveyResult::where('survey_id',$survey_id)->get();
        return view('user.formResults',compact('survey_results','orgId','modules'));
    }

    public function showCreateForm(){
        $uri = explode("/",$_SERVER['REQUEST_URI']);

        $organisation=Organisation::find($uri[1]);
        $orgId=$organisation->id;
        $dbName=$organisation->name.'_'.$organisation->id;
        $org_roles = $this->getOrganisationRoles($orgId);

        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);
        $modules= DB::collection('modules')->get();

		$projects = DB::collection('projects')->get(); 
        $categories = DB::collection('categories')->get();         
        $microservices = Microservice::where('is_active',true)->get(); 
        $entities = Entity::where('is_active',true)->get(); 

        return view('index',compact(['orgId','modules','microservices','org_roles','projects','categories','entities']));
    }

    public function editForm($orgId,$survey_id)
    {
        $organisation=Organisation::find($orgId);
        $dbName=$organisation->name.'_'.$orgId;

        $org_roles = $this->getOrganisationRoles($orgId);

        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);
        
        $survey = DB::collection('surveys')->where('_id',$survey_id)->get();

        $surveyJson = $survey[0]['json'];
        $surveyID = $survey[0]['_id'];

        $surveys = $survey[0]['project_id'].' '.$survey[0]['category_id'].' '.$survey[0]['microservice_id'].' '.$survey[0]['creator_id'].' '.$survey[0]['active'].' '.$survey[0]['editable'].' '.$survey[0]['multiple_entry'].' '.$survey[0]['entity_id'];
        $roles = $survey[0]['assigned_roles'];
     
        $modules= DB::collection('modules')->get();
		$projects = DB::collection('projects')->get(); 
        $categories = DB::collection('categories')->get(); 
        $microservices = Microservice::where('is_active',true)->get(); 
        $entities = Entity::where('is_active',true)->get(); 

        return view('admin.surveys.edit',compact('surveyID','surveys','roles','microservices','entities','surveyJson','orgId','modules','org_roles','projects','categories'));
    }
    public function saveEditedForm(Request $request)
    {
        $r = json_decode($request->json,true);
        $k = null;

        foreach($r as $key=>$value)
        {
            if($key == 'title')
                $k = $value;
        }    
      
        //form the connection string to the DB
        $organisation=Organisation::find($request->orgId);
        $dbName=$organisation->name.'_'.$organisation->id;
        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);
 
       
         DB::collection('surveys')->where('_id',$request->surveyID)->update(
            ['name'=>$k ,'json'=>$request->json,
            'active'=>$request->active,'editable'=>$request->editable,
            'multiple_entry'=>$request->multiple_entry,'assigned_roles'=>$request->assigned_roles,
            'category_id'=>$request->category_id,'project_id'=>$request->project_id,
            'microservice_id'=>$request->microservice_id,
            'entity_id'=>$request->entity_id
            ]
        );

        return json_encode($request->surveyID);
     
    }

    public function getOrganisationRoles($orgId){
        $roles= Role::where('org_id','=',$orgId)->get();
        return $roles;
    }   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($survey_id)
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

        DB::collection('surveys')->where('_id',$survey_id)->delete();

        $modules= DB::collection('modules')->get();
        
        return Redirect::back()->withMessage('Form Deleted');
        
    }
}
