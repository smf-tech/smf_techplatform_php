<?php 

namespace App;

use App\Traits\CreatorDetails;
use App\State;
use App\District;
use App\Taluka;
use App\Village;

class Location extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;
    
    protected $table = 'locations';

    protected $fillable=['jurisdiction_type_id'];


    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function taluka()
    {
        return $this->belongsTo(Taluka::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }
}