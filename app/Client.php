<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];
    
     public function reviews() {
        return $this->hasMany('App\ReviewRequest', 'client_id');
    }
}
