<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = ["full_url", "short_url", "description", "times_used"];
}
