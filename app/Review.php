<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class Review extends Model
{
    use Uuid;
    protected $keyType = 'string';
    public $incrementing = false;
}
