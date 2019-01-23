<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Organisation;
use Illuminate\Support\Facades\Auth;

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
}
