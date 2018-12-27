<?php

use Illuminate\Database\Seeder;
use App\Jurisdiction;
use App\Organisation;
use App\User;
use Maklad\Permission\Models\Role;
use Maklad\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions=[
        [
        'name'=>'role-read',
        'display_name'=>'Display Role Listing',
        'description'=>'see listing roles'
        ],
        [
        'name'=>'role-create',
        'display_name'=>'Create Role',
        'description'=>'Create new Role'
        ],
        [
        'name'=>'role-edit',
        'display_name'=>'Edit Role',
        'description'=>'Edit Role'
        ],
        [
        'name'=>'role-delete',
        'display_name'=>'Delete Role',
        'description'=>'Delete Role'
        ],
        [
        'name'=>'user-list',
        'display_name'=>'display user',
        'description'=>'display user'
        ]
        ];

        foreach($permissions as $key=>$value){
            Permission::create($value);
        }

        $level=[
                 [
                    'levelName'=>'District',
                 ],
                [
                    'levelName'=>'Taluka',
                ],
                [
                    'levelName'=>'Cluster',
                ],
                [
                    'levelName'=>'Village',
                ]
            ];
   
   
        foreach($level as $key=>$value){
            Jurisdiction::create($value);
        }
        $orgdata = ['name'=>'rootorg','service'=>'test','orgshow'=>0];
        Organisation::create($orgdata);
        $org=Organisation::where('name', 'rootorg')->get()->first();
        $roledata = ['name'=>'ROOTORGADMIN','display_name'=>'RootOrgAdmin','description'=>'','org_id'=> $org->id];
        Role::create($roledata);
        $role= Role::where('name', 'ROOTORGADMIN')->get()->first();
        $user_data = ['name'=>'rootorgadmin','email'=>'rootadmin@gmail.com','password'=>bcrypt('123456'),'org_id'=> $org->id,'role_id'=>$role->id,'gender'=>'male','phone'=>'9876543210'];
        User::create($user_data);
        $user= User::where('email', 'rootadmin@gmail.com')->get()->first();
        $user->assignRole($role->name);

    }
}
