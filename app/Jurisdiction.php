<?php 

namespace App;

use App\Traits\CreatorDetails;

class Jurisdiction extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;
    
    protected $fillable=['level'];
}