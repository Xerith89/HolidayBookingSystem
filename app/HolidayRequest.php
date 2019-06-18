<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HolidayRequest extends Model
{
    protected $dates = ['created_at', 'updates_at', 'request_start', 'request_end'];

    public function user(){
        $this->belongsTo('App\User');
    }
}

