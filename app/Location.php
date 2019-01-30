<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location  extends \Jenssegers\Mongodb\Eloquent\Model
{
    protected $table = 'locations';

    protected $fillable=['jurisdiction_type_id','level'];
}