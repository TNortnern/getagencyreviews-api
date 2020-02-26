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

    public function user() {
        return $this->belongsTo('App\Users');
    }

    //
}
