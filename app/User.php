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
        'name', 'username', 'email', 'password',
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
        return $this->create($this->transformRequest($request));
    }
    
    /**
     * @param $request
     *
     * @return \App\User
     */
    public function updateFromRequest($request) {
        $this->update($this->transformRequest($request));
        
        return $this;
    }
    
    /**
     * @param $request
     *
     * @return array
     */
    protected function transformRequest($request) {
        return [
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => $request->password
        ];
}
}
