<?php
namespace App;

use App\Traits\CreatorDetails;

class Survey extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;
    
    protected $fillable = [
        'name', 'json', 'project_id','category_id','creator_id','microservice_id','entity_id',//slug',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function results()
    {
        return $this->hasMany('App\SurveyResult', 'form_id');
    }
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
    public function microservice()
    {
        return $this->belongsTo('App\Microservice');
    }
    public function entity()
    {
        return $this->belongsTo('App\Entity');
    }
}