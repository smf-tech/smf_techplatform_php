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
    public function getOrgRoles(Request $request)
    {
        $roles=Role::where('org_id', $request->selectedOrg)->get();       
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
        $permissions = Permission::all();
        $orgs = Organisation::where('orgshow','<>',0)->get();
        // $levels = Jurisdiction::all();
        
        return view('admin.roles.create_role',compact(['permissions','orgs']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $project_id = $request->project_id;
        $role = Role::create([
            'name'=>$request->name.'_'.$request->org_id,
            'display_name'=>$request->display_name,
            'description'=>$request->description,
            'org_id'=>$request->org_id,
            // 'jurisdiction_id' => $request->level_id,
            'user_ids'=>[],
            'project_id'=>$project_id
        ]);

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
    public function edit(Request $request,$id)
    {
         $role = Role::find($id);        
         $orgs = Organisation::where('orgshow','<>',0)->get();
        //  $levels = Jurisdiction::all();
         $role_jurisdictions=RoleJurisdiction::where('role_id',$role->id)->get();
         $project_id = '';
         if (isset($role->project_id) && !empty($role->project_id)) {
            $project_id = $role->project_id;
         } 
         $org_id = $role->org_id;
         $data['orgID'] = $org_id;
         $request->merge($data);
         $non_ajax_call_flag = true;
         $projects_arr = $this->getAjaxOrgId($request,$non_ajax_call_flag);
         
         return view('admin.roles.edit',compact(['role','orgs','role_jurisdictions','project_id','projects_arr']));
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
        $role->display_name=$request->display_name;
        $role->description=$request->description;
        $role->org_id=$request->org_id;
        // $role->jurisdiction_id=$request->level_id;
        $role->project_id=$request->project_id;
        $role->save();
        
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
        // var_dump($role);exit;
        if(isset($role->user_ids) && !empty($role->user_ids)) {
            foreach($role->user_ids as $role_user_id_val) {
                $user = User::find($role_user_id_val);
                if($user !== null && $user->hasRole($role->name)) {
                    $user->removeRole($role->name);
                }
            }
        }
        $role->delete();
        return redirect()->route('role.index')->with('message','Role Deleted Successfuly!');
    }

    public function getAjaxOrgId(Request $request, $non_ajax_call_flag = null)
    {    
      $org_id = $request->orgID;
      $organisation = Organisation::find($org_id);
      $dbName = $organisation->name.'_'.$org_id;
      \Illuminate\Support\Facades\Config::set('database.connections.'.$dbName, array(
            'driver'    => 'mongodb',
            'host'      => '127.0.0.1',
            'database'  => $dbName,
            'username'  => '',
            'password'  => '',  
        ));
        
        DB::setDefaultConnection($dbName);
        $projects = DB::collection('projects')->get();
        if (isset($non_ajax_call_flag)) {
            return $projects;
        } else {
            return json_encode($projects);
        }
    }

}