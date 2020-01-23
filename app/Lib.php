<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lib extends Model
{
    protected $table = "libs";

    protected $fillable = [
        "name",
        "description"
    ];
}
