<?php

namespace App;

use App\CustomTrait\Uuid;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use Uuid;

    protected $guarded = [];

    public function getChannelName() {
        return $this->to < $this->from ? ("message." . $this->to . '-' . $this->from) : ("message." . $this->from . '-' . $this->to);
    }
}
