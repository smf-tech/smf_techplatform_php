<?php

namespace App;

use App\Traits\CreatorDetails;

class Taluka extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;
    
    protected $fillable=['Name','state_id','district_id'];

    public function district()
    {
        return $this->belongsTo('App\District');
    }

    public function State()
    {
        return $this->belongsTo('App\State');
    }
}
