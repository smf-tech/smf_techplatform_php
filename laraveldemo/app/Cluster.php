<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    protected $fillable=['Name','state_id','district_id','taluka_id','districtName','talukaName','stateName'];

    public function villages()
    {
        return $this->hasMany('App\Village');
    }

     public function taluka()
    {
        return $this->belongsTo('App\Taluka');
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
