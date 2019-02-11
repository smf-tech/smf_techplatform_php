<?php

namespace App;

use App\Traits\CreatorDetails;

class smsAuth extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;
    
    protected $fillable=['phone','otp'];

}
