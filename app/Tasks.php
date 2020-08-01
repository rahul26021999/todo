<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $fillable = [
        'title', 'user_id','status'
    ];

    function User(){
    	return $this->belongsTo('App\User');
    }
}
