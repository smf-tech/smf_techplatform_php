<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['name'];
}
