@extends('layouts.app')

@section('content')
  <div id="projects" class="container">
    <h1 class="mt-3">Found {{ count($movies) }} movies</h1>
        <div class="row"> <!-- change to <div class="card-columns"> for masonry style-->
        @foreach($movies as $movie)
            <div class="col-md-3">   <!-- remove for masonry style-->
                <div class="card h-100"> <!-- remove h-100 for masonry style-->
                    @if( isset($movie->poster) )
                        <a href="/movies/{{$movie->id}}"><img class="card-img-top" src="data:image/jpeg;base64,{{ base64_encode(file_get_contents($movie->poster)) }}" alt=""></a>
                    @else
                        <a href="/movies/{{$movie->id}}"><img class="card-img-top" src="{{ asset('img/default-movie-poster.jpg') }}" alt=""></a>
                    @endif
                    <div class="card-body">
                        <h4 class="card-title"><a href="/movies/{{$movie->id}}">{{ $movie->title }}</a></h4>
                        <ul>
                            @if( isset($movie->year) ) <li>{{ $movie->year  }}</li>@else<li>Year unknown  </li>@endif
                            @if( isset($movie->genre) )<li>{{ $movie->genre }}</li>@else<li>Genre unknown </li>@endif
                            @if( isset($movie->stars) )<li>{{ $movie->stars }}</li>@else<li>Actors unknown</li>@endif
                        </ul>
                        <p class="card-text">{{ $movie->description }}</p>            
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection