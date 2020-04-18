<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dashboard_post extends Model
{

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:00',
        'updated_at' => 'datetime:Y-m-d H:00'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
