<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class userDet extends Model
{
    protected $fillable = [
        'user_id', 'state_id', 'district_id','taluka_id','village_id','cluster_id'
    ];
}

