<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
     * @param $request
     *
     * @return \App\User
     */
    public function createFromRequest($request) {
        return null;
    }
    
    /**
     * @param $request
     *
     * @return \App\User
     */
    public function updateFromRequest($request) {
        return null;
    }
}
