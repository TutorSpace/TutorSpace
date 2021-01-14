<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class CancellationPenalty extends Model
{
    use Uuid;

    protected $keyType = 'string';
    public $incrementing = false;

    public function user() {
        return $this->belongsTo('App\User');
    }
}
