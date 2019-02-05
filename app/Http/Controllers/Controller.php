<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Organisation;
use Illuminate\Support\Facades\Auth;
use App\StructureMaster;
use App\MachineMaster;
use App\MachineMou;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Sets database configuration
     *
     * @param string $orgId
     * @return array
     */
    public function setDatabaseConfig($orgId = null)
    {
        if ($orgId === null) {
            $orgId = Auth::user()->org_id;
        }
        $organisation = Organisation::find($orgId);

        $dbName = $organisation->name . '_' . $orgId;
        \Illuminate\Support\Facades\Config::set(
                'database.connections.' . $dbName,
                [
                    'driver'    => 'mongodb',
                    'host'      => '127.0.0.1',
                    'database'  => $dbName,
                    'username'  => '',
                    'password'  => '',
                ]
            );
        return [$orgId, $dbName];
    }

    public function importCSVData($model)
    {
        $filePath = '';
        switch ($model) {
            case $model === StructureMaster::class:
                $filePath = public_path('master-data/structure_master.csv');
                break;
            case $model === MachineMaster::class:
                $filePath = public_path('master-data/machine_master.csv');
                break;
            case $model === MachineMou::class:
                $filePath = public_path('master-data/machine_mou.csv');
                break;
        }
        if (empty($filePath)) {
            return;
        }
        $data = $this->csvToArray($filePath);
        if (!$data) {
            return;
        }
        for ($i = 0; $i < count($data); $i++) {
            $model::firstOrCreate($data[$i]);
        }
        return true;
    }

    private function csvToArray($filename)
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = null;
        $data = [];
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        return $data;
    }
}
