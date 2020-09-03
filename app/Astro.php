<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Astro extends Model
{
    protected $primaryKey = 'id';
    protected $table = "astro";
    protected $fillable = [
        "name", 
        "birth"
    ];
    public $timestamps = true;
}

