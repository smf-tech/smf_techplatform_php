<?php

namespace App;

use App\Traits\CreatorDetails;

class Module extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;
    
    protected $fillable = ['name'];
}
