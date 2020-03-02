<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone_number'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'links' => 'array'
    ];
    public function agents() {
        return $this->hasOne('App\Agents');
    }
    public function profile() {
        return $this->hasOne('App\UserProfile', 'user');
    }
    public function reviews() {
        return $this->hasMany('App\Reviews');
    }
    public function reviewRequest() {
        return $this->hasMany('App\ReviewRequest');
    }
}
