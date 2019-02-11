<?php

namespace App;

use App\Traits\CreatorDetails;

class Project extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;
    
    protected $fillable = [
        'name',
        'jurisdiction_type_id'
    ];

    public function jurisdiction()
    {
        return $this->belongsTo('App\Jurisdiction');
    }
}
