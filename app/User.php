<?php

namespace App;

use Illuminate\Notifications\Notifiable;
/*use Illuminate\Foundation\Auth\User as Authenticatable;*/
/*use Jenssegers\Mongodb\Auth\User as Authenticatable;*/
/*use Zizaco\Entrust\Traits\EntrustUserTrait;*/
use Laravel\Passport\HasApiTokens;
use Maklad\Permission\Traits\HasRoles;
use DesignMyNight\Mongodb\Auth\User as Authenticatable;
use App\Traits\CreatorDetails;

class User  extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use HasApiTokens;
    use CreatorDetails;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','gender','dob','phone','org_id','role_id','approved'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
	    /**
     * Find the user identified by the given $identifier.
     *
     * @param $identifier email|phone
     * @return mixed
     */
    public function findForPassport($identifier) {
        return User::orWhere('email', $identifier)->orWhere('phone', $identifier)->first();
    }
}
