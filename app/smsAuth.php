<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class smsAuth extends  \Jenssegers\Mongodb\Eloquent\Model
{
    protected $fillable=['phone','otp'];

}
