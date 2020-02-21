<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
     protected $fillable = [
        'user',
        'agent',
        'review',
        'rating',
        'email'
    ];

    public function agents() {
        return $this->belongsTo('App\Agents');
    }

    //
}
