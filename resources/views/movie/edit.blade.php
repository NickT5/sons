@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit this movie</div>

                <div class="card-body">
                    <form action="/movies/{{$movie->id}}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter a movie title" value="{{$movie->title}}" autocomplete="off" disabled>
                            @error('title') <p style="color: red;">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="hidden" name="seen" value="0">
                                @if( $seen == "1" )
                                    <input class="form-check-input" name="seen" value="1" type="checkbox" id="seen" checked>
                                @else
                                    <input class="form-check-input" name="seen" value="1" type="checkbox" id="seen">
                                @endif
                                <label class="form-check-label" for="seen">Have you seen the movie?</label>
                            </div>
                        </div>

                        <div class="form-row mt-4">
                            <div class="form-group col-md-6">
                                <label for="year">Year</label>
                                <input type="text" class="form-control" id="year" value="{{$movie->year}}" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="genre">Genre</label>
                                <input type="text" class="form-control" id="genre" value="{{$movie->genre}}" disabled>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="stars">Stars</label>
                            <input type="text" class="form-control" id="stars" value="{{$movie->stars}}" disabled>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="rating">Rating</label>
                                <input type="text" class="form-control" id="rating" value="{{$movie->rating}}" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="runtime">Runtime</label>
                                <input type="text" class="form-control" id="runtime" value="{{$movie->runtime}}" disabled>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="director">Director</label>
                            <input type="text" class="form-control" id="director" value="{{$movie->director}}" disabled>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description"  disabled> {{$movie->description}} </textarea>
                        </div>


                        <div class="d-flex justify-content-between">
                            <a href='/movies/{{$movie->id}}' class="btn btn-primary">Go back</a>
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
