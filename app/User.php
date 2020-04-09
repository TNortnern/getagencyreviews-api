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
    // public function reviews() {
    //     return $this->hasMany('App\Reviews', 'agent_id');
    // }
    public function reviewRequest() {
        return $this->hasMany('App\ReviewRequest', 'agent_id');
    }
    public function clients()
    {
        return $this->hasManyThrough('App\Client', 'App\ReviewRequest', 'agent_id', 'id')->select([
            'clients.name',
            'clients.email',
            'clients.phone_number',
            'review_requests.id as review_id',
            'email_sent',
            'email_opened',
            'link_clicked',
            'star_rating_completed',
            'star_rating',
            'feedback_completed',
            'feedback',
            'external_link_clicked',
            'external_review_completed',
            'review_requests.created_at as reviews_created_at',
            'review_requests.updated_at as reviews_updated_at',
        ]);
    }
}
