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

    // important: this function and subscribeNewMessageChannel() are tightly connected. Needs to change the other when either one of them is changed
    public function getChannelName() {
        return strcmp($this->to, $this->from) < 0 ? ("message." . $this->to . '.' . $this->from) : ("message." . $this->from . '.' . $this->to);
    }
}
