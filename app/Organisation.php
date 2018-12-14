<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organisation  extends \Jenssegers\Mongodb\Eloquent\Model
{
    protected $fillable=['name','service'];
}
