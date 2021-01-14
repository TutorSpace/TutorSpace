<?php

namespace App\CustomTrait;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

trait Uuid {

    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

}
