<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class Message extends Model
{
    use Uuid;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $guarded = [];

    public function getChannelName() {
        return $this->to < $this->from ? ("message." . $this->to . ';' . $this->from) : ("message." . $this->from . ';' . $this->to);
    }
}
