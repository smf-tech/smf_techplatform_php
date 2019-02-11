<?php

namespace App;

use App\Traits\CreatorDetails;

class Organisation extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;
    
    protected $attributes = ['orgshow' => 1];
    protected $fillable=['name','service'];
}
