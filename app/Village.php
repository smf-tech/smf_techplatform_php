<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $fillable=['Name','state_id','district_id','taluka_id'];

    public function district()
    {
        return $this->belongsTo('App\District');
    }

    public function State()
    {
        return $this->belongsTo('App\State');
    }
    public function taluka()
    {
        return $this->belongsTo('App\Taluka');
    }

    public function cluster()
    {
        return $this->belongsTo('App\Cluster');
    }
}
