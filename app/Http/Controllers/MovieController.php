<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{

    public function __construct()
    {
        // Redirect user to login page if he/she is not logged in. Alternative: add middleware('auth') in the route.
        $this->middleware('auth');
    }

    
    public function index()
    {
        // Retrieve the the related movies from the authenticated user. 
        $movies_seen = auth()->user()->movies()->wherePivot('seen', 1)->get();
        $movies_notseen = auth()->user()->movies()->wherePivot('seen', 0)->get();

        return view('movie.index', compact('movies_seen', 'movies_notseen'));
    }

    
    public function create()
    {
        return view('movie.create');
    }


    public function store()
    {
        // Returns an array with the request attributes that meet the required conditions.
        $validated = request()->validate([
            'title' => 'required|min:2|max:255',
            'seen' => 'boolean'
        ]);

        // Make Http GET request to a 3rd party API (= OMDb api), to get more information about the movie.
        $info = $this->call_omdb_api($validated);

        // Check if omdb api found a valid result.
        if(!isset($info['Error']))
        {            
            /*The firstOrCreate method will attempt to locate a database record using the given column / value pairs. 
            If the model can not be found in the database, a record will be inserted with the attributes from the first parameter,
            along with those in the optional second parameter.*/
            $movie = \App\Movie::firstOrCreate(['title' => $validated['title'],
                                             'year' => $info['Year'],
                                             'genre' => $info['Genre'],
                                             'stars' => $info['Actors'],
                                            'poster' => $info['Poster'],
                                            'rating' => $info['imdbRating'],
                                            'runtime' => $info['Runtime'],
                                            'director' => $info['Director'],
                                            'description' => $info['Plot'],
                                            'director' => $info['Director']]);

            // Attach movie id and user id to pivot table if record doesn't exists.
            if(! auth()->user()->movies()->where(['movie_id' => $movie->id, 'user_id' => auth()->user()->id])->exists())
            {
                auth()->user()->movies()->attach($movie->id, ['seen' => $validated['seen']]);
            }

            $seen = $validated['seen'];
        }
    
        return view('movie.show', compact('movie', 'seen'));
    }

    
    public function show(\App\Movie $movie)
    {
        $seen = auth()->user()->movies()->where('movie_id', $movie->id)->first()->pivot->seen;

        return view('movie.show', compact('movie', 'seen'));
    }

    
    public function edit(\App\Movie $movie)
    {
        $seen = auth()->user()->movies()->where('movie_id', $movie->id)->first()->pivot->seen;

        return view('movie.edit', compact('movie', 'seen'));
    }

    
    public function update(\App\Movie $movie)
    {
        $validated = request()->validate([
            'seen' => 'boolean'
        ]);

        auth()->user()->movies()->updateExistingPivot($movie->id, ['seen' => $validated['seen']]);
 
        return redirect('/movies');
    }

    
    public function destroy(\App\Movie $movie)
    {
        auth()->user()->movies()->detach($movie->id);

        return redirect('/movies');
    }


    public function search(Request $request)
    {
        $filter_by = $request->input('filter_by') ?? 'title';
        $q = $request->input('q');

        $movies = auth()->user()->movies()->where($filter_by, 'LIKE',  "%{$q}%")
                        ->orderBy('title')
                        ->get(); 

        return view('movie.search', compact('movies') );
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
