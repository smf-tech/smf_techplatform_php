<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\Role;
use App\Permission;
use App\Organisation;
use App\Jurisdiction;
use App\RoleJurisdiction;
use App\StateJurisdiction;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getJuris(Request $request)
    {
        $levels = DB::table('state_jurisdictions')->where('state_id',$request->state_id)->get(['jurisdiction_id']);
   
        $levelNames=array();
        foreach ($levels as $level)
        {
            $levelName=DB::table('jurisdictions')->where('id',$level->jurisdiction_id )->get();
            array_push($levelNames, $levelName[0]);
        }

        $response=array($levelNames);
        return json_encode($response);
    }

    public function getOrgRoles(Request $request){
  
        $roles=Role::where('org_id', $request->selectedOrg )->get();
       
        return json_encode($roles);
    }
    public function index()
    {
        $roles=Role::paginate(5);
        return view('admin.roles.role_index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $permissions=Permission::all();
        $orgs=Organisation::all();
        $levels = Jurisdiction::all();
        $states = State::all();

        return view('admin.roles.create_role',compact(['permissions','orgs','levels','states']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $role=Role::create($request->except(['permission','_token','level_id']));

            $s = new RoleJurisdiction;
            $s->role_id = $role->id;
            $s->state_id = $request->state_id;
            $s->jurisdiction_id = $request->jurisdiction;
            $s->save();

            if(count($request->permission)> 0){
                foreach($request->permission as $key=>$value){
                    $role->attachPermission($value);
                }
            } 
      
        return redirect()->route('role.index')->withMessage('Role Created');
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
         $role=Role::find($id);
         $states=State::all();
         $permissions=Permission::all();
         $role_permissions=$role->perms()->pluck('id','id')->toArray();
         $orgs=Organisation::all();
         $role_jurisdictions=RoleJurisdiction::where('role_id',$id)->get();
         $levels = StateJurisdiction::where('state_id',$role_jurisdictions[0]->state_id)->get(['jurisdiction_id']);
         $levelNames=array();
         foreach ($levels as $level)
         {
             $levelName=DB::table('jurisdictions')->where('id',$level->jurisdiction_id )->get(['levelName']);
             array_push($levelNames,$levelName[0]);
         }
         return view('admin.roles.edit',compact(['role','role_permissions','permissions','orgs','levels','levelNames','role_jurisdictions','states']));
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
        $role=Role::find($id);
        $role->name=$request->name;
        $role->display_name=$request->display_name;
        $role->description=$request->description;
        $role->org_id=$request->org_id;
        $role->save();

        DB::table('permission_role')->where('role_id',$id)->delete();

        if(count($request->permission)> 0)
        {
            foreach($request->permission as $key=>$value)
            {
                $role->attachPermission($value);
            }
        } 
        
        $sj = RoleJurisdiction::where('role_id',$role->id)->get();

        if ($request->jurisdiction != $sj[0]->jurisdiction_id)
        {
            RoleJurisdiction::where('role_id',$id)->delete();

                $s = new RoleJurisdiction;
                $s->role_id = $id;
                $s->jurisdiction_id = $request->jurisdiction;
                $s->state_id = $request->state_id;
                $s->save();

        }
       
        return redirect()->route('role.index')->withMessage('Role Edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('permission_role')->where('role_id',$id)->delete();

        DB::table('roles')->where('id',$id)->delete();
        return redirect()->route('role.index')->withMessage('Role Deleted');
    }

    public function getTenantRoles()
    {   
        /*$role_model_instance = new Role;
        $role_model_instance->setConnection('tenant_db');
        //dd($role_model_instance->setConnection('tenant_db')::find(1));
        $roles=DB::connection('tenant_db')->table('roles')->get();*/
        $role_model_instance = new Role;
        $roles  = $role_model_instance->setConnection('tenant_db')->get(); 
        //dd($roles );     
        return view('admin.roles.tenantrole_index',compact('roles'));

    }
    
}