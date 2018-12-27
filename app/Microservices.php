<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Microservices extends \Jenssegers\Mongodb\Eloquent\Model
{
    protected $fillable=['name','description','base_url','route'];
}
