<?php

namespace App;

use App\Traits\CreatorDetails;

class StructureMaster extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;

    protected $fillable = [
        'state',
        'district',
        'taluka',
        'village',
        'structure_code',
        'structure_name',
        'structure_owner_department',
        'structure_owner_department_sub_type',
        'type',
        'number_of_catchment_villages',
        'village_population'
    ];
}
