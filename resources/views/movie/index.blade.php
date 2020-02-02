@extends('layouts.app')

@section('scripts')
    <script src="https://use.fontawesome.com/7dc64d3e62.js"></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ auth()->user()->name }}'s overview
                    <form action="/search" method="get" class="d-flex">
                        <select class="custom-select"  name="filter_by">
                            <option value="" disabled selected>Filter by</option>
                            <option value="title">Title</option>
                            <option value="genre">Genre</option>
                            <option value="year">Year</option>
                        </select>

                        <input type="text" class="form-control" placeholder="Search..." name="q" autocomplete="off">
                        <button type="submit" class="btn btn-outline-success"><i class="fa fa-search "></i></button>
                    </form>
                </div>

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
