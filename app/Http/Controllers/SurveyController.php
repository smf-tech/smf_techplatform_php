<?php

namespace App\Http\Controllers;
use App\Survey;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class SurveyController extends Controller
{

    public function getJSON(Request $request)
    {
        // return $request;
        $r = json_decode($request->json,true);
        $k = null;

        foreach($r as $key=>$value)
        {
            if($key == 'title')
                $k = $value;
        }    
        $survey = new Survey;
        $survey->name = $k;
        $survey->json = $request->json;
        $survey->creator_id = $request->creator_id;
        $survey->save();
        // DB::insert('insert into surveys (name,json,creator_id) values(?,?,?)',[$k,$request->json,$request->creator_id]);

        return view('admin.surveys.index',compact('surveys'));
    }
    public function getReply(Request $request)
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
        DB::insert('insert into survey_results (survey_id,user_id,json) values(?,?,?)',[$request->surveyId,$request->userId,$request->jsonString]);

        return null;
    }
    public function display(Request $request)
    {
        $json = $request->json;
        $survey_id = $request->surveyID;
        // return $json;
        return view('layouts.survey',compact('json','survey_id'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $surveys=Survey::paginate(5);
        // return $survey;
        return view('admin.surveys.index',compact('surveys'));
        // print_r(DB::select('select * from surveys'));
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
