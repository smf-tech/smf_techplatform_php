<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends \Jenssegers\Mongodb\Eloquent\Model
{
    protected $fillable = [
        'name',
        'jurisdiction_type_id'
    ];

    public function jurisdiction()
    {
        return $this->belongsTo('App\Jurisdiction');
    }
}
