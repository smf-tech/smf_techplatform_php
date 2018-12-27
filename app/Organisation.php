<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organisation  extends \Jenssegers\Mongodb\Eloquent\Model
{
    protected $attributes = ['orgshow' => 1];
    protected $fillable=['name','service'];
}
