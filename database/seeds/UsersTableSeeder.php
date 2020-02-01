<?php

use Illuminate\Database\Seeder;
use \App\User;
use \App\Movie;

use \App\Http\Controllers\MovieController;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        // Create a dummy user.
        $user = User::create([
            'name' => 'Nick',
            'email' => 'nick@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('nick')
        ]);

        // Create a few dummy movies that the user has or hasn't seen.
        $info = MovieController::call_omdb_api(['title'=>'John+Wick']);
        Movie::create([
            'title' => 'John Wick',
            'seen' => '1',
            'user_id' => $user->id,
            'year' => $info['Year'],
            'genre' => $info['Genre'],
            'stars' => $info['Actors'],
            'poster' => $info['Poster'],
            'rating' => $info['imdbRating'],
            'runtime' => $info['Runtime'],
            'director' => $info['Director'],
            'description' => $info['Plot']
        ]);

        $info = MovieController::call_omdb_api(['title'=>'Knives+Out']);
        Movie::create([
            'title' => 'Knives Out',
            'seen' => '0',
            'user_id' => $user->id,
            'year' => $info['Year'],
            'genre' => $info['Genre'],
            'stars' => $info['Actors'],
            'poster' => $info['Poster'],
            'rating' => $info['imdbRating'],
            'runtime' => $info['Runtime'],
            'director' => $info['Director'],
            'description' => $info['Plot']
        ]);

        $info = MovieController::call_omdb_api(['title'=>'1917']);
        Movie::create([
            'title' => '1917',
            'seen' => '0',
            'user_id' => $user->id,
            'year' => $info['Year'],
            'genre' => $info['Genre'],
            'stars' => $info['Actors'],
            'poster' => $info['Poster'],
            'rating' => $info['imdbRating'],
            'runtime' => $info['Runtime'],
            'director' => $info['Director'],
            'description' => $info['Plot']
        ]);
    }
}
