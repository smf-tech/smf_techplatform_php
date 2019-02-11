<?php 

namespace App;

use App\Traits\CreatorDetails;

class Location extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;
    
    protected $table = 'locations';

    protected $fillable=['jurisdiction_type_id','level'];

    public function jurisdictionType()
    {
        return $this->belongsTo('App\JurisdictionType');
    }
}