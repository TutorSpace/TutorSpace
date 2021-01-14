<?php

namespace App;

use App\CustomTrait\Uuid;
use Illuminate\Database\Eloquent\Model;

class PostDraft extends Model
{
    use Uuid;
    protected $table="post_drafts";
    protected $guarded = [];
}
