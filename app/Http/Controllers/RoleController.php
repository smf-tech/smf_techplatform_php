<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
#use App\Role;
#use App\Permission;
use App\Organisation;
use App\Jurisdiction;
use App\RoleJurisdiction;
use App\User;
use Illuminate\Support\Facades\DB;

use Maklad\Permission\Models\Role;
use Maklad\Permission\Models\Permission;

class RoleController extends Controller
{
   
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOrgRoles(Request $request){
  
        $roles=Role::where('org_id', $request->selectedOrg )->get();       
        return json_encode($roles);
    }
    public function index()
    {
        $roles=Role::all();
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
        $orgs=Organisation::where('orgshow','<>',0)->get();
        $levels = Jurisdiction::all();
        
        return view('admin.roles.create_role',compact(['permissions','orgs','levels']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $role=Role::create([
            'name'=>$request->name.'_'.$request->org_id,
            'display_name'=>$request->display_name,
            'description'=>$request->description,
            'org_id'=>$request->org_id,
            'jurisdiction' => $request->level_id,
            'user_ids'=>[]
        ]);
            $s = new RoleJurisdiction;
            $s->role_id = $role->_id;
            $s->jurisdiction_id = $request->level_id;
            $s->save();

        session()->flash('status', 'Role was created!');
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
         $orgs=Organisation::where('orgshow','<>',0)->get();
         $levels = Jurisdiction::all();
         $role_jurisdictions=RoleJurisdiction::where('role_id',$role->id)->get();

         return view('admin.roles.edit',compact(['role','orgs','levels','role_jurisdictions']));
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

        $sj = RoleJurisdiction::where('role_id',$role->id)->delete();

                $s = new RoleJurisdiction;
                $s->role_id = $role->id;
                $s->jurisdiction_id = $request->level_id;
                $s->save();

                session()->flash('status', 'Role was updated!');
        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        if(isset($role['user_ids'])){
            foreach($role['user_ids'] as $role_user_id_key=>$role_user_id_val){
                    $user = User::find($role_user_id_val);
                    if($user->hasRole($role->name)){
                        $user->removeRole($role->name);
                    }
            }
        }
        $role->delete();
        return redirect()->route('role.index')->with('message','Role Deleted Successfuly!');
    }


}