<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Taluka;
use App\District;
use App\State;
use App\Jurisdiction;
use App\StateJurisdiction;
use Illuminate\Support\Facades\DB;

class TalukaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tal = Taluka::all();
        return view('admin.talukas.talukas_index',compact('tal'));
    }
    public function getJidandLevel(Request $request){
        $jIdsAndLevel=StateJurisdiction::where('state_id',$request->stateId)->orderBy('level', 'ASC')->get(['jurisdiction_id','level']);
     
        $levelNames=array();
        if($request->flevel!='')
        foreach ( $jIdsAndLevel as $item){
          
            $jurisdictionName=Jurisdiction::where('id',$item->jurisdiction_id )->get(['levelName']);
         
           
            if($jurisdictionName[0]->levelName==$request->flevel) return json_encode($levelNames);
            else
            array_push($levelNames, $jurisdictionName[0]->levelName);
          
        }

        else
        if($request->roleLevel!=""){
            foreach ( $jIdsAndLevel as $item){
          
                $jurisdictionName=Jurisdiction::where('id',$item->jurisdiction_id )->get(['levelName']);
             
               
                if($jurisdictionName[0]->levelName==$request->roleLevel) {
                    array_push($levelNames, $jurisdictionName[0]->levelName);
                    return json_encode($levelNames);
                }
                else
                array_push($levelNames, $jurisdictionName[0]->levelName);
              
            }
        }
        else
        {
            foreach ( $jIdsAndLevel as $item){
          
                $jurisdictionName=Jurisdiction::where('id',$item->jurisdiction_id )->get(['levelName']);
             
               
                if($jurisdictionName[0]->levelName==$request->flevel)  {
                     array_push($levelNames, $jurisdictionName[0]->levelName);
                 return json_encode($levelNames);
                }
                else
                array_push($levelNames, $jurisdictionName[0]->levelName);
              
            }

        }
        return json_encode($levelNames);
    }
    public function populateData(Request $request){
       
        $tableName="";
        switch($request->item){
            case 'Taluka':$tableName='talukas';break;
            case 'District':$tableName='districts';break;
            case 'Village':$tableName='villages';break;
            case 'Cluster':$tableName='clusters';break;
        }
        
      
        if($request->district!=''){
           // return json_encode('district : '+$request->district+"\n taluka  : "+$request->taluka+'  State : '+$request->state);
            $res=DB::table($tableName)->where('district_id',$request->district)->get();
        }
        else
        if($request->taluka!=''){
            //  return json_encode('district : '+$request->district+"\n taluka  : "+$request->taluka+'  State : '+$request->state);
            $res=DB::table($tableName)->where('taluka_id',$request->taluka)->get();
        }
        else 
        if($request->cluster!=''){
           // return json_encode($tableName);
          // return json_encode('cluster : '+$request->cluster+'  State : '+$request->state);
            $res=DB::table($tableName)->where('cluster_id',$request->cluster)->get();
        }
       else
        $res=DB::table($tableName)->where('state_id',$request->state)->get();
        return json_encode($res);
    }


   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //to get only those states that have taluka as the jurisdiction level
       $levelId=Jurisdiction::where('LevelName','Taluka')->get(['id']);
   
        $stateIds=StateJurisdiction::where('jurisdiction_id',$levelId[0]->id)->get(['state_id']);
        $states=State::whereIn('id',$stateIds)->get();
        
        return view('admin.talukas.create_taluka',compact('states'));   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $tal = new Taluka;
        $tal->Name = $request->talukaName;
        $tal->state_id = $request->state_id;
        $tal->district_id = $request->District;
        
       
      
        $tal->save();
        return redirect()->route('taluka.index')->withMessage('Taluka Created');
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
        $tal = Taluka::find($id);
        $states = State::all();
        $districts = District::all();
    
        return view('admin.talukas.edit',compact('tal','states','districts'));
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
        $tal=Taluka::find($id);
        // $dis->id=$request->id;
        $tal->talukaName=$request->talukaName;
        $tal->state_id = $request->state_id;
        $tal->district_id = $request->district_id;
        $tal->save();

        return redirect()->route('taluka.index')->withMessage('Taluka Edited');   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tal=Taluka::find($id)->delete();
        return redirect()->route('taluka.index')->withMessage('Taluka Deleted');                
    }
}
