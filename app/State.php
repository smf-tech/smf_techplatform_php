<?php 

namespace App;

use App\Traits\CreatorDetails;

class State extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;

    protected $fillable=['Name'];
   
}