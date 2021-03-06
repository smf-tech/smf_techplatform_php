<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taluka extends Model
{
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
