<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Associate extends \Jenssegers\Mongodb\Eloquent\Model
{
    protected $fillable = [
        'name',
        'type', // => donor, vendor, partner 
        'contact_number', 
        'contact_person'
    ];
}
