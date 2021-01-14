<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class PostDraft extends Model
{
    use Uuid;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $table="post_drafts";
    protected $guarded = [];
}
