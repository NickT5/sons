<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    // Redirect user to login page if he/she is not logged in. Alternative: add middleware('auth') in the route.
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function index()
    {
        // Fetch seen and not-seen movies.
        $movies_seen = DB::select("SELECT * FROM movies WHERE user_id = :user_id AND seen = :seen", 
                        ['user_id' => auth()->user()->id,
                         'seen' => "1"]);
        $movies_notseen = DB::select("SELECT * FROM movies WHERE user_id = :user_id AND seen = :seen", 
                        ['user_id' => auth()->user()->id,
                         'seen' => "0"]);

        return view('movie.index', compact('movies_seen', 'movies_notseen'));
    }

    public function create()
    {
        return view('movie.create');
    }

    public function store()
    {
        // Returns an array with the request attributes that meet the required conditions.
        $data = request()->validate([
            'title' => 'required|min:2|max:255',
            'seen' => 'boolean'
        ]);

        // Make Http GET request to a 3rd party API (= OMDb api), to get more information about the movie.
        $info = $this->call_omdb_api($data);

        if(!isset($info['Error']))
        {
            $data['year'] = $info['Year'];
            $data['genre'] = $info['Genre'];
            $data['stars'] = $info['Actors'];
            $data['poster'] = $info['Poster'];
            $data['rating'] = $info['imdbRating'];
            $data['runtime'] = $info['Runtime'];
            $data['director'] = $info['Director'];
            $data['description'] = $info['Plot'];
        }

        $movie = auth()->user()->movies()->create($data);  // Insert a new movie record with request data and the authenticated user.
        
        return view('movie.show', compact('movie'));
    }

    public function show(\App\Movie $movie)
    {
        return view('movie.show', compact('movie'));
    }

    public function edit(\App\Movie $movie)
    {
        return view('movie.edit', compact('movie'));
    }

    public function update(\App\Movie $movie)
    {
        $data = request()->validate([
            'title' => 'required|min:2|max:255',
            'seen' => 'boolean'
        ]);

        // Make Http GET request to a 3rd party API (= OMDb api), to get more information about the movie.
        $info = $this->call_omdb_api($data);

        if(!isset($info['Error']))
        {
            $data['year'] = $info['Year'];
            $data['genre'] = $info['Genre'];
            $data['stars'] = $info['Actors'];
            $data['poster'] = $info['Poster'];
            $data['rating'] = $info['imdbRating'];
            $data['runtime'] = $info['Runtime'];
            $data['director'] = $info['Director'];
            $data['description'] = $info['Plot'];
        }
        else{
            $data['year'] = null;
            $data['genre'] = null;
            $data['stars'] = null;
            $data['poster'] = null;
            $data['rating'] = null;
            $data['runtime'] = null;
            $data['director'] = null;
            $data['description'] = null;
        }

        $movie->update($data);
        
        return redirect('/movies');
    }

    public function destroy(\App\Movie $movie)
    {
        $movie->delete();
        return redirect('/movies');
    }

    public static function call_omdb_api($data)
    {
         // Make a Http GET request to a 3rd party API (= OMDb api) to get more information about the movie.
         $client = new \GuzzleHttp\Client();
         $key = env("API_OMDB_KEY");
         $api = "http://www.omdbapi.com/?apikey={$key}";
         $title = str_replace(' ', '+', $data['title']);
         $uri = "{$api}&t={$title}";

         $response = $client->get($uri);
         return json_decode($response->getBody()->getContents(), true);
    }

}
