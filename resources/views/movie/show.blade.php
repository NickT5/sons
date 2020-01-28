@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Movie details</div>

                    <div class="card-body">
                        <div>
                            <strong>Title</strong>
                            <p>{{ $movie->title }}</p>

                            <strong>Have you seen this movie?</strong>
                            <p>
                                @if($movie->seen == '1')
                                Yes
                                @else
                                No
                                @endif    
                            </p>
                        </div>

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
            </div>    
        </div>
    </div>
</div>

@endsection