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
        // Fetch all movies.
        //$movies = \App\Movie::all();

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
        $http_client = new \GuzzleHttp\Client();
        $omdbapi = "http://www.omdbapi.com/?apikey=88076cbf";
        $title = str_replace(' ', '+', $data['title']);
        $uri = "{$omdbapi}&t={$title}";
        $response = $http_client->get($uri);
        $code = $response->getStatusCode();
        $type =  $response->getHeaderLine('content-type');
        $body = $response->getBody();

       $info = json_decode($response->getBody()->getContents(), true);

        print $info['Year'] .", ". $info['Runtime'];
        dd($info);

        $movie = auth()->user()->movies()->create($data);  // Insert a new movie record with request data and the authenticated user.
        
        return redirect('/movies');
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

        $movie->update($data);
        
        return redirect('/movies');
    }

    public function destroy(\App\Movie $movie)
    {
        $movie->delete();
        return redirect('/movies');
    }

}
