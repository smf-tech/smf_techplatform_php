<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $fillable=['Name','state_id','district_id','taluka_id','cluster_id'];
    
    public function cluster()
    {
        return $this->belongsTo('App\Cluster');
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
