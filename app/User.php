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
    public function profile() {
        return $this->hasOne('App\UserProfile', 'user');
    }
    public function reviewRequest() {
        return $this->hasMany('App\ReviewRequest', 'agent_id');
    }
    public static function clients($id)
    {
        if ($id) {
            return ReviewRequest::where('agent_id', $id)->whereHas('client', function($q) {
                $q->where(['isDeleted' => 0]);
            })->with('client')->get();
        }
    }
    public static function isUnique($email, $agent) {
        $clients = User::clients($agent);
        $unique = true;
        foreach ($clients as $reviewItem) {
            if ($reviewItem->client->email === $email) {
                $unique = false;
                break;
            }
        }
        return $unique;

    }
}
