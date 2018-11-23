<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable=['Name','state_id'];

    public function state()
    {
        return $this->belongsTo('App\State');
    }
}
