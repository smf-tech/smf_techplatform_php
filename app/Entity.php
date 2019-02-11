<?php

namespace App;

use App\Traits\CreatorDetails;

class Entity extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;

    protected $fillable = [
        'Name','display_name'
    ];
}
