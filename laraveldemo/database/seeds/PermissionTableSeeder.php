<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Jurisdiction;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$permissions=[
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
        }*/

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

    }
}
