<?php

namespace App;

use App\CustomTrait\Uuid;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use Uuid;

    public function user() {
        return $this->belongsTo('App\User');
    }
}
