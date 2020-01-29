<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    // Fields inside the $fillable property can be mass assigned using Eloquent’s create() and update() methods.
    protected $fillable = ['title', 'seen', 'year', 'genre', 'stars', 'poster', 'rating', 'runtime', 'director', 'description', 'user_id']; 
    //protected $guarded = [];  // Alternative for $fillable.

    // Define the inverse relation to the User. 
    // Get the user record associated with the movie.
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
