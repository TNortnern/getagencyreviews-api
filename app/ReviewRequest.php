<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewRequest extends Model
{
    protected $guarded = [];

    public function agent() {
        return $this->belongsTo('App\User', 'agent_id');
    }
    public function client() {
        return $this->belongsTo('App\Client', 'client_id');
    }
}
