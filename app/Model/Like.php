<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public $table = 'blog_like';

    public $primaryKey = "id";

    public $timestamps = false;

    public $guarded = [];
}