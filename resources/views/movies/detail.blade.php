@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="row no-gutters">
        <div class="col-md-4">
            {{-- Gambar di halaman detail langsung dimuat karena tidak ada lazyload --}}
            <img src="{{ $movie->getPosterUrl() }}" class="card-img" alt="{{ $movie->title }}">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h2 class="card-title">{{ $movie->title }} ({{ $movie->year }})</h2>
                <p class="card-text"><strong>{{ trans('messages.genre') }}:</strong> {{ $movie->genre }}</p>
                <p class="card-text"><strong>{{ trans('messages.director') }}:</strong> {{ $movie->director }}</p>
                <p class="card-text"><strong>{{ trans('messages.actors') }}:</strong> {{ $movie->actors }}</p>
                <p class="card-text"><strong>{{ trans('messages.plot') }}:</strong> {{ $movie->plot }}</p>
                <p class="card-text"><strong>{{ trans('messages.rating') }}:</strong> {{ $movie->imdbRating }} / 10</p>
                <p class="card-text"><strong>{{ trans('messages.awards') }}:</strong> {{ $movie->awards }}</p>
                <p class="card-text"><strong>{{ trans('messages.box_office') }}:</strong> {{ $movie->boxOffice }}</p>

                @if ($isFavorite)
                    <form action="{{ route('favorites.destroy', $movie->imdbID) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ trans('messages.remove_favorite') }}</button>
                    </form>
                @else
                    <form action="{{ route('favorites.store') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="imdb_id" value="{{ $movie->imdbID }}">
                        <button type="submit" class="btn btn-warning">{{ trans('messages.add_favorite') }}</button>
                    </form>
                @endif
                <a href="{{ route('movies.list') }}" class="btn btn-secondary">{{ trans('messages.back_to_list') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection