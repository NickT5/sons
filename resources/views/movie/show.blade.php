@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>Details of movie</h1>

            <div>
                <a href='/movies' class="btn btn-primary">Go back</a>
            </div>

            <div>
                <strong>Title</strong>
                <p>{{ $movie->title }}</p>

                <strong>Have you seen this movie?</strong>
                <p>{{ $movie->seen }}</p>
            </div>

            <div>
                <a href='/movies/{{$movie->id}}/edit' class="btn btn-info">Edit</a>
                <form action='/movies/{{$movie->id}}' method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Remove</button>
                </form>
            </div>
            
        </div>
    </div>
</div>

@endsection