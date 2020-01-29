@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Movie page</h1>

    <div class="row">
        <div class="col-md-5">
            <img class="img-fluid" src="{{asset('img/750x500.png')}}" alt="">
        </div>

        <div class="col-md-7">
            <h3 class="my-3">Movie details</h3>
            <ul>
                @foreach($movie->getAttributes() as $key => $value)
                    @if(in_array($key, ['title', 'year', 'genre', 'stars', 'rating', 'runtime', 'director']))
                        @if($value != "")
                            <li>{{ ucfirst($key) }} - <strong>{{ $value }}</strong></li>
                        @else
                            <li>{{ ucfirst($key) }} - not set</li>                    
                        @endif
                    @endif
                @endforeach
            </ul>

            <h3>Info</h3>
            <p>Have you seen this movie?
                @if($movie->seen == '1')
                    <strong>Yes</strong>
                @else
                    <strong>No</strong>
                @endif
            </p>
        </div>
    </div>

    <div class="row">
        <div class=col-md-12>
            <h3 class="my-3">Movie description</h3>
            @if($movie->description != "")
                <p>{{ $movie->description }}</p>
            @else
                <p>Not set.</p>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between">
                <a href='/movies' class="btn btn-primary">Go back</a>
                <div class="d-flex justify-content-right">
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
  <!-- /.row -->

@endsection