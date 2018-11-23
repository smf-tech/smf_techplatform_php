<?php

use Illuminate\Database\Seeder;
use App\Jurisdiction;
class JurisdictionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
