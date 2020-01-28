<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = ['title', 'seen', 'user_id']; // Nodig voor App\Model::create()
    #protected $guarded = [];  # Turn off mass assignment protection. Alternative for $fillable.

    // Define the inverse relation to the User. 
    // Get the user record associated with the movie.
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
