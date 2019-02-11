<?php

namespace App;

use App\Report;
use App\Traits\CreatorDetails;

class Category extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;

    protected $fillable = [
        'name','type'
    ];

    public function reports()
    {
        return $this->hasMany(Report::class,'category_id');
    }
}
