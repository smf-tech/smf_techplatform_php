<?php

namespace App\Http\Controllers;
use App\Survey;
use App\Organisation;
use Maklad\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\SurveyResult;
use Illuminate\Http\Request;
use Auth;

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
 
       
         DB::collection('surveys')->insert(
            ['name'=>$k ,'json'=>$request->json,'creator_id'=> $request->creator_id,
            'active'=>$request->active,'editable'=>$request->editable,
            'multiple_entry'=>$request->multiple_entry,'assigned_roles'=>$request->assigned_roles,
            'category_id'=>$request->category_id,'project_id'=>$request->project_id,
            'microservice_id'=>$request->microservice_id]
        );

        return json_encode('success');
     
    }
    public function sendResponse(Request $request)
    {
        // $survey = new SurveyResult;
        // $survey->survey_id = $request->surveyId;
        // $survey->user_id = $request->userId;
        // $survey->json = $request->jsonString;
        // $survey->save();

        // if($request->jsonString == '{}')
        //     echo "Please fill out form";
        // else
        // {

        // }
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
        // return $json;
        return view('layouts.survey',compact('json','survey_id','orgId','modules'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   //getOranisation
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
        // $projects = 
        // return $survey;
        return view('admin.surveys.survey_index',compact('surveys','orgId','modules'));
        // print_r(DB::select('select * from surveys'));
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
        $microservices = DB::collection('microservices')->get(); 

        return view('index',compact(['orgId','modules','microservices','org_roles','projects','categories']));
    }

    public function editForm($org_id,$survey_id)
    {
        $organisation=Organisation::find($org_id);
        $dbName=$organisation->name.'_'.$org_id;

        $org_roles = $this->getOrganisationRoles($org_id);

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

        $surveys = $survey[0]['project_id'].' '.$survey[0]['category_id'].' '.$survey[0]['microservice_id'].' '.$survey[0]['creator_id'].' '.$survey[0]['active'].' '.$survey[0]['editable'].' '.$survey[0]['multiple_entry'];
        $roles = $survey[0]['assigned_roles'];
     
        $modules= DB::collection('modules')->get();

		$projects = DB::collection('projects')->get(); 
        $categories = DB::collection('categories')->get(); 
        $microservices = DB::collection('microservices')->get(); 
        
        return view('admin.surveys.edit',compact('surveyID','surveys','roles','microservices','surveyJson','org_id','modules','org_roles','projects','categories'));
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
            // 'creator_id'=> $request->creator_id,
            'active'=>$request->active,'editable'=>$request->editable,
            'multiple_entry'=>$request->multiple_entry,'assigned_roles'=>$request->assigned_roles,
            'category_id'=>$request->category_id,'project_id'=>$request->project_id,
            'microservice_id'=>$request->microservice_id]
        );

        return json_encode('success');
     
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
    public function destroy($ids)
    {
        // Getting individual ids: id[0] = survey id, id[1] = organisation id
        $id = explode(" ", $ids);
        $organisation=Organisation::find($id[1]);
        $dbName=$organisation->name.'_'.$id[1];

        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        DB::setDefaultConnection($dbName);

        DB::collection('surveys')->where('_id',$id[0])->delete();

        $modules= DB::collection('modules')->get();
        $orgId = $id[1];
        $surveys=Survey::paginate(5);
        DB::setDefaultConnection('mongodb');
       
        // return view('layouts.editSurvey',compact('surveys','orgId','modules'));
        
        return view('admin.surveys.survey_index',compact('surveys','orgId','modules'));
        
    }
}
