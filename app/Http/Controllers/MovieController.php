<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $movies = \App\Movie::all();

#        $seen_movies = \App\Movie::findOrFail()->user()->where('seen', '1')->all();
        #dd($seen_movies);

        return view('movie.index', compact('movies'));
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
        
        dd($movie);

        return redirect('/movies');
    }

}
