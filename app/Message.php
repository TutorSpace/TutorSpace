<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = [];

    public function getChannelName() {
        return $this->to < $this->from ? ("message." . $this->to . '-' . $this->from) : ("message." . $this->from . '-' . $this->to);
    }
}
