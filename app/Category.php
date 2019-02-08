<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Report;

class Category extends \Jenssegers\Mongodb\Eloquent\Model
{
    protected $fillable = [
        'name','type'
    ];

    public function reports()
    {
        return $this->hasMany(Report::class,'category_id');
    }
}
