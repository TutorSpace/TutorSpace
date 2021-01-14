<?php

namespace App;

use App\CustomTrait\Uuid;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use Uuid;
}
