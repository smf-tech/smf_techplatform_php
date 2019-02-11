<?php
namespace App;

use App\Traits\CreatorDetails;
use App\User;

class SurveyResult extends \Jenssegers\Mongodb\Eloquent\Model
{
    use CreatorDetails;
    
    protected $table = 'survey_results';
    protected $fillable = [
        'survey_id', 'user_id', 'json', //'ip_address',
    ];
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function survey()
    {
        return $this->belongsTo('App\Survey', 'form_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}