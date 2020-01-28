@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ auth()->user()->name }}'s dashboard</div>

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <h2>SONS</h2>
                        <a href='/movies/create' class="btn btn-primary">Add new movie</a>
                    </div>

                    <div>
                        <h2>Seen</h2>
                        <ul>
                            @forelse($movies_seen as $movie)
                                <a href='/movies/{{$movie->id}}'><li> {{ $movie->title }} </li></a>
                            @empty
                                <p>You haven't added any movies yet.</p>
                            @endforelse
                        </ul>
                    </div>

                    <div>
                        <h2>Not seen</h2>
                        <ul>
                            @forelse($movies_notseen as $movie)
                                <a href='/movies/{{$movie->id}}'><li> {{ $movie->title }} </li></a>
                            @empty
                                <p>You haven't added any movies yet.</p>
                            @endforelse
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
