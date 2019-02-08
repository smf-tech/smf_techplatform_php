<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report  extends \Jenssegers\Mongodb\Eloquent\Model
{
    protected $fillable = ['name', 'description', 'url', 'category','active'];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
