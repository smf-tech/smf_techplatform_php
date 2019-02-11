<?php

namespace App;

use App\Traits\CreatorDetails;

class Microservice extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;
    
    protected $fillable=['name','description','base_url','route','is_active'];
}
