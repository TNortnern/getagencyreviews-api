<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agents extends Model
{
     protected $fillable = [
        'user'
    ];

    public function users() {
        return $this->belongsTo('App\User', 'user');
    }

    public function reviews() {
        return $this->hasMany('App\Reviews');
    }
    //
}
