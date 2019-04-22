<?php
namespace App;

use App\Traits\CreatorDetails;
use App\Event;

class EventType extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;

    
    protected $fillable = [];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->hasMany('App\Event');
    }
}