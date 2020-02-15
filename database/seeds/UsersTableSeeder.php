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
        // Create a user.
        $user = User::create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('test')
        ]);

        // Create a few movies.
        $info = MovieController::call_omdb_api(['title'=>'John+Wick']);
        $movie1 = Movie::create([
            'title' => 'John Wick',
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
        $movie2 = Movie::create([
            'title' => 'Knives Out',
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
        $movie3 = Movie::create([
            'title' => '1917',
            'year' => $info['Year'],
            'genre' => $info['Genre'],
            'stars' => $info['Actors'],
            'poster' => $info['Poster'],
            'rating' => $info['imdbRating'],
            'runtime' => $info['Runtime'],
            'director' => $info['Director'],
            'description' => $info['Plot']
        ]);

        //Link movies with the user.
        $user->movies()->attach($movie1, ['seen' => 1]);
        $user->movies()->attach($movie2, ['seen' => 0]);
        $user->movies()->attach($movie3, ['seen' => 0]);

    }
}
