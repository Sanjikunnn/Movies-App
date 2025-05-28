<div class="col-12 col-md-6 col-lg-4 col-xl-3">
    <div class="movie-card card h-100 shadow-sm">
        {{-- PASTIKAN POSTER-CONTAINER MEMILIKI position-relative --}}
        <div class="poster-container position-relative">
            <img class="card-img-top lazyload"
                 data-src="{{ $movie->getPosterUrl() }}"
                 alt="{{ $movie->title }}"
                 loading="lazy">

            {{-- Badge Rating - Pindah ke Kanan Atas --}}
            <div class="position-absolute top-0 end-0 m-2">
                <span class="badge bg-warning text-dark">
                    <i class="fas fa-star"></i> {{ $movie->imdbRating ?? 'N/A' }}
                </span>
            </div>

            {{-- JIKA ADA BADGE LAIN, PASTIHAN TIDAK BERTUMPUK DENGAN INI --}}
            {{-- Contoh: Jika ada badge favorite count, bisa geser sedikit ke bawah --}}
            {{--
            <div class="position-absolute top-0 start-0 m-2">
                <span class="badge bg-primary text-white">
                    <i class="fas fa-heart"></i> {{ \App\Favorite::where('imdb_id', $movie->imdbID)->count() }}
                </span>
            </div>
            --}}
        </div>

        <div class="card-body">
            <h5 class="card-title text-truncate">{{ $movie->title }}</h5>
            <div class="d-flex justify-content-between text-muted small">
                <span>{{ $movie->year }}</span>
                <span>{{ $movie->type }}</span>
            </div>

            @if($movie->genre)
            <div class="my-2">
                @foreach(explode(', ', $movie->genre) as $genre)
                <span class="badge bg-secondary me-1">{{ $genre }}</span>
                @endforeach
            </div>
            @endif

            <p class="card-text small text-truncate-3">{{ $movie->plot ?? trans('messages.no_plot_available') }}</p>
        </div>

        <div class="card-footer bg-white d-flex justify-content-between">
            <a href="{{ route('movies.detail', $movie->imdbID) }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-info-circle"></i>
            </a>
            <form action="{{ route('favorites.store') }}" method="POST">
                @csrf
                <input type="hidden" name="imdb_id" value="{{ $movie->imdbID }}">
                <button type="submit" class="btn btn-sm btn-outline-warning">
                    <i class="fas fa-heart"></i> {{ \App\Favorite::where('imdb_id', $movie->imdbID)->count() }}
                </button>
            </form>
        </div>
    </div>
</div>