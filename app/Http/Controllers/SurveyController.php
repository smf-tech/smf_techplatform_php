<?php

namespace App\Http\Controllers;
use App\Survey;
use App\Organisation;
use Illuminate\Support\Facades\DB;
use App\SurveyResult;
use Illuminate\Http\Request;

class SurveyController extends Controller
{

    public function getJSON(Request $request)
    {
        $r = json_decode($request->json,true);
        //Set default Form title
        $k = 'Untitled';

        foreach($r as $key=>$value)
        {
            if($key == 'title')
                $k = $value;
        }    
      
        //form the connection string to the DB
        $organisation=Organisation::find($request->orgId);
        $dbName=$organisation->name.'_'.$organisation->id;
        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => 'root',
            'password'  => '',  
        ));       
        DB::setDefaultConnection($dbName); 
       
         DB::table('surveys')->insert(
            ['name'=>$k ,'json'=>$request->json,'creator_id'=> $request->creator_id]
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
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => 'root',
            'password'  => '',  
        ));       
        DB::setDefaultConnection($dbName); 
       

        DB::insert('insert into survey_results (survey_id,user_id,json) values(?,?,?)',[$request->surveyId,$request->userId,$request->jsonString]);

        return null;
    }
    public function display(Request $request)
    {     $uri = explode("/",$_SERVER['REQUEST_URI']);

        $organisation=Organisation::find($uri[1]);
        $orgId=$organisation->id;
        $dbName=$organisation->name.'_'.$organisation->id;
        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => 'root',
            'password'  => '',  
        ));       
        DB::setDefaultConnection($dbName); 
        $modules= DB::connection($dbName)-> select('select * from modules');

        $json = $request->json;
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
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => 'root',
            'password'  => '',  
        ));       
        DB::setDefaultConnection($dbName); 
        $modules= DB::connection($dbName)-> select('select * from modules');


        $surveys=Survey::paginate(5);
        // return $survey;
        return view('admin.surveys.index',compact('surveys','orgId','modules'));
        // print_r(DB::select('select * from surveys'));
    }
    public function viewResults(Request $request){
        $survey_id=$request->surveyID;
        $uri = explode("/",$_SERVER['REQUEST_URI']);

        $organisation=Organisation::find($uri[1]);
        $orgId=$organisation->id;
        $dbName=$organisation->name.'_'.$organisation->id;
        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => 'root',
            'password'  => '',  
        ));       
        DB::setDefaultConnection($dbName);
        $modules= DB::connection($dbName)-> select('select * from modules');

        $survey_results=SurveyResult::where('survey_id',$survey_id)->get();
        return view('user.formResults',compact('survey_results','orgId','modules'));
    }
    public function showCreateForm(){
        $uri = explode("/",$_SERVER['REQUEST_URI']);

        $organisation=Organisation::find($uri[1]);
        $orgId=$organisation->id;
        $dbName=$organisation->name.'_'.$organisation->id;
        \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mysql',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => 'root',
            'password'  => '',  
        ));       
        DB::setDefaultConnection($dbName); 
        $modules= DB::connection($dbName)-> select('select * from modules');

        return view('index',compact(['orgId','modules']));
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
    public function destroy($id)
    {
        //
    }
}
