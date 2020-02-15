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
        /*$movies_seen = DB::select("SELECT * FROM movies WHERE user_id = :user_id AND seen = :seen", 
                        ['user_id' => auth()->user()->id,
                         'seen' => "1"]);
        $movies_notseen = DB::select("SELECT * FROM movies WHERE user_id = :user_id AND seen = :seen", 
                        ['user_id' => auth()->user()->id,
                         'seen' => "0"]);
        */
        /*$movies_seen = auth()->user()->movies()->where('seen', '1')->get();
        $movies_notseen = auth()->user()->movies()->where('seen', '0')->get();
        */

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
            /*
            $movie = new \App\Movie;

            $movie->title = $validated['title'];
            $movie->year = $info['Year'];
            $movie->genre = $info['Genre'];
            $movie->stars = $info['Actors'];
            $movie->poster = $info['Poster'];
            $movie->rating = $info['imdbRating'];
            $movie->runtime = $info['Runtime'];
            $movie->director = $info['Director'];
            $movie->description = $info['Plot'];

            $movie->save();*/
            
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
        $movie = auth()->user()->movies()->where('movie_id', $movie->id)->first();
        if($movie == null) abort(404);
        $seen = $movie->pivot->seen;
        return view('movie.show', compact('movie', 'seen'));
    }

    public function edit(\App\Movie $movie)
    {
        $movie = auth()->user()->movies()->where('movie_id', $movie->id)->first();
        if($movie == null) abort(404);
        $seen = $movie->pivot->seen;

        return view('movie.edit', compact('movie', 'seen'));
    }

    public function update(\App\Movie $movie)
    {
        $validated = request()->validate([
            'seen' => 'boolean'
        ]);

        auth()->user()->movies()->updateExistingPivot($movie->id, ['seen' => $validated['seen']]);

        // Make Http GET request to a 3rd party API (= OMDb api), to get more information about the movie.
        /*$info = $this->call_omdb_api($validated);

        if(!isset($info['Error']))
        {
            $data['title'] = $validated['title'];
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
        */
        
        return redirect('/movies');
    }

    public function destroy(\App\Movie $movie)
    {
        //$movie->delete();
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
