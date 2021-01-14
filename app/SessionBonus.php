<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class SessionBonus extends Model
{
    use Uuid;

    public $timestamp = true;
    protected $keyType = 'string';
    public $incrementing = false;

    public function session() {
        return $this->belongsTo('App\Session');
    }
}
