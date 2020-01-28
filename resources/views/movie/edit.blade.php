@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add a new movie to your list</div>

                <div class="card-body">
                    <form action="/movies/{{$movie->id}}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Enter a movie title" value="{{$movie->title}}" autocomplete="off">
                            @error('title') <p style="color: red;">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="hidden" name="seen" value="0">
                                <input class="form-check-input" name="seen" value="1" type="checkbox" id="seen">
                                <label class="form-check-label" for="seen">Have you seen the movie?</label>
                            </div>
                        </div>

                        <div>
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
