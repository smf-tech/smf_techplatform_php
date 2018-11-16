<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taluka extends Model
{
    protected $fillable=['Name','state_id','district_id','stateName','districtName'];

    public function clusters()
    {
        return $this->hasMany('App\Cluster');
    }

    public function district()
    {
        return $this->belongsTo('App\District');
    }
    public function state()
    {
        return $this->belongsTo('App\State');
    }
}
