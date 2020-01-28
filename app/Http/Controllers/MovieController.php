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
        #dd($movies_seen);


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

        // Create new movie, set attributes and save to the database.
        /*$movie = new \App\Movie;
        $movie->title = $data['title'];
        $movie->seen = $data['seen'];
        $movie->save();
        */ 

        $movie = auth()->user()->movies()->create($data);  // Insert a new movie record with request data and the authenticated user.
        
        return redirect('/movies');
    }

}
