<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $guarded = [];  # Turn off mass assignment protection. Alternative is protected $fillable = ['title', 'seen'];
}
