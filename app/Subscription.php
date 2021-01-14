<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class Subscription extends Model
{
    use Uuid;

    protected $keyType = 'string';
    public $incrementing = false;

    // everything is fillable
    protected $guarded = [];
}
