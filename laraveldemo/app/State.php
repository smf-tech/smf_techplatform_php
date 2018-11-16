<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable=['Name'];
   
    public function districts()
    {
        return $this->hasMany('App\District');
    }
}