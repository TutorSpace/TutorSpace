<?php

namespace App;

use App\CustomTrait\Uuid;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use Uuid;

    // everything is fillable
    protected $guarded = [];
}
