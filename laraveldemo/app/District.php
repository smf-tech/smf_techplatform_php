<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable=['Name','state_id','state_name'];

    public function talukas()
    {
        return $this->hasMany('App\Taluka');
    }

    public function state()
    {
        return $this->belongsTo('App\State');
    }

}
