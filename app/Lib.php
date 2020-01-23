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

    public function images(){
        return $this->hasMany(Image::class,"lib_id","id");
    }
}
