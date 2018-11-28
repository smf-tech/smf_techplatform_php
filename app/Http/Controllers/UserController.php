<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Organisation;
use App\RoleJurisdiction;
use App\State;
use App\UserDetails;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    /**
     * addition of middleware for restricting access
     */
    function __construct(){
        $this->middleware('role:ROOTORGADMIN')->only(['create','edit','store','destroy']);
    }


    /**
     * AJAX call handler to populate the states dropdown based on the role selection
     *
     * @return json reponse
     */
    
    public function getLevel(Request $request){
        //get the level for a particular role and based on that level populate the states selection
        $level= RoleJurisdiction::where('role_id',$request->role_id)->get();
        
        $states=DB::table('state_jurisdictions')->where('jurisdiction_id',$level[0]->jurisdiction_id)->get();
        
    
        $stateNames=array();
        foreach ($states as $state){
           
            $stateName=DB::table('states')->where('id',$state->state_id )->get();
         
            array_push($stateNames,$stateName[0]);
        }
       
       
        $levelName=DB::table('jurisdictions')->where('id',$level[0]->jurisdiction_id)->get();
      //  return json_encode($levelName);
        $response=array($levelName[0]->levelName,$stateNames);
        return json_encode($response);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::all();
        
        return view('admin.users.user_index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $orgs=Organisation::all();
        
        $states=State::all();
        return view('admin.users.create_user',compact(['orgs','states']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    $clusters=$villages=$talukas=$districts=array(null);
         $arrayItems=array();
        foreach($_REQUEST as $key=>$value){
            if(is_array($value)){
               array_push($arrayItems,$key);
            }
        }
        foreach($arrayItems as $key=>$value){
           switch($value){
               case 'Cluster': $clusters= $request->Cluster;break;
               case 'Village': $villages= $request->Village;break;
               case 'Taluka': $talukas= $request->Taluka;break;
               case 'District':  $districts= $request->District;break;

           }
        }
              
       
        $states= $request->state_id;
      
         $data= $request->except(['role','_token']);
         $user=User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' =>  bcrypt($data['password']),
            'phone' => $data['phone'],
            'dob' => $data['dob'],
            'gender' => $data['gender'],
            'org_id'=>$data['org_id'],
            'role_id'=>$data['role_id']
        ]);
   
        $user=DB::select('select * from users where email = ?', [$data['email']]);
      
        //make an entry in the roles users table
        DB::insert('insert into role_user (user_id,role_id) values(?,?)',[$user[0]->id,$data['role_id']]);
       

        UserDetails::create([
            'user_id' => $user[0]->id,
            'state_id' => implode(',', $states),
            'district_id' =>implode(',', $districts),
            'taluka_id' => implode(',', $talukas),
            'village_id' => implode(',', $villages),
            'cluster_id' => implode(',', $clusters),
        
        ]);


        return redirect()->route('users.index')->withMessage('User Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::find($id);
        $orgs=Organisation::all();
        $orgId=$user['org_id'];
        $roleId=$user['role_id'];
        $userDet=userDet::where('user_id',$id)->get();
        $stateId=$userDet[0]->state_id;
        
        $role=Role::find($roleId);
        $states=State::all();

        

        

        return view('admin.users.edit',compact(['user','orgs','states','orgId','role','stateId']));
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
        $user=User::find($id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->org_id=$request->org_id;
        $user->role_id=$request->role_id;
        $user->save();
        DB::table('role_user')->where('user_id',$id)->delete();
        DB::table('user_dets')->where('user_id',$id)->delete();

        $clusters=$villages=$talukas=$districts=array(null);
        $arrayItems=array();
       foreach($_REQUEST as $key=>$value){
           if(is_array($value)){
              array_push($arrayItems,$key);
           }
       }
       foreach($arrayItems as $key=>$value){
          switch($value){
              case 'Cluster': $clusters= $request->Cluster;break;
              case 'Village': $villages= $request->Village;break;
              case 'Taluka': $talukas= $request->Taluka;break;
              case 'District':  $districts= $request->District;break;

          }
       }

       $states= $request->state_id;

       UserDetails::create([
        'user_id' => $id,
        'state_id' => implode(',', $states),
        'district_id' =>implode(',', $districts),
        'taluka_id' => implode(',', $talukas),
        'village_id' => implode(',', $villages),
        'cluster_id' => implode(',', $clusters),
    
    ]);


        DB::insert('insert into role_user (user_id,role_id) values(?,?)',[$id,$request->role_id]);
        return redirect()->route('users.index')->withMessage('User Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('role_user')->where('user_id',$id)->delete();

        DB::table('users')->where('id',$id)->delete();
        return redirect()->route('users.index')->withMessage('Role Deleted');
    }
}
