<?php

namespace App;

use App\Traits\CreatorDetails;

class JurisdictionType extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;
    
    protected $fillable = ['jurisdictions'];

    public function locations()
    {
        return $this->hasMany('App\Location', 'jurisdiction_type_id');
    }
}
