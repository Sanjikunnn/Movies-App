@extends('layouts.app')

@section('content')
    {{-- Search Form --}}
    <div class="row mb-5">
        <div class="col-12">
            <form action="{{ route('movies.list') }}" method="GET" class="search-form">
                <div class="form-row justify-content-center g-3">
                    <div class="col-12 col-md-5">
                        <div class="input-group custom-input-group-text"> {{-- Apply custom-input-group-text --}}
                            <span class="input-group-text bg-primary text-white">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control custom-form-control" {{-- Apply custom-form-control --}}
                                   placeholder="{{ trans('messages.search_movie') }}" value="{{ $search }}">
                        </div>
                    </div>

                    <div class="col-6 col-md-2">
                        <select name="type" class="form-control custom-form-control"> {{-- Apply custom-form-control --}}
                            <option value="">{{ trans('messages.all_types') }}</option>
                            @foreach(['movie', 'series', 'episode'] as $t)
                            <option value="{{ $t }}" {{ $type == $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Hilangkan input year untuk saat ini jika tidak digunakan --}}
                    {{-- <div class="col-6 col-md-2">
                        <input type="number" name="year" class="form-control custom-form-control" placeholder="{{ trans('messages.year') }}" value="{{ $year }}">
                    </div> --}}

                    <div class="col-12 col-md-2">
                        <button type="submit" class="btn btn-primary search-button w-100"> {{-- Apply search-button --}}
                            {{ trans('messages.search') }} <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Content --}}
    @if(isset($no_results))
        <div class="text-center py-5 empty-state"> {{-- Apply empty-state --}}
            <i class="fas fa-film fa-3x text-muted mb-3"></i>
            <h3 class="text-primary">{{ trans('messages.no_results_found') }}</h3>
            <button onclick="location.reload()" class="btn btn-outline-secondary cta-button btn-outline-primary mt-3"> {{-- Apply cta-button --}}
                <i class="fas fa-redo"></i> {{ trans('messages.clear_search') }}
            </button>
        </div>
    @elseif(!empty($movies))
        <h2 class="section-title"><span>{{ trans('messages.search_results') }}</span></h2> {{-- Section Title for results --}}
        <div class="row g-4" id="movie-list">
            @foreach($movies as $movie)
                @include('movies.card', ['movie' => $movie])
            @endforeach
        </div>

        {{-- Pagination --}}
        @if ($totalResults > 0)
            <div class="d-flex justify-content-center my-5">
                <nav aria-label="Page navigation">
                    <ul class="pagination neobrutal-pagination"> {{-- Tambahkan class untuk styling --}}
                        {{-- Previous Page Link --}}
                        <li class="page-item {{ $page <= 1 ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ route('movies.list', array_merge(request()->query(), ['page' => $page - 1])) }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>

                        {{-- Pagination Elements (looping terbatas) --}}
                        @php
                            $startPage = max(1, $page - 2);
                            $endPage = min($totalPages, $page + 2);

                            if ($page - 2 < 1) { // Sesuaikan jika terlalu dekat ke awal
                                $endPage = min($totalPages, $endPage + (1 - ($page - 2)));
                            }
                            if ($page + 2 > $totalPages) { // Sesuaikan jika terlalu dekat ke akhir
                                $startPage = max(1, $startPage - (($page + 2) - $totalPages));
                            }
                        @endphp

                        @for ($i = $startPage; $i <= $endPage; $i++)
                            <li class="page-item {{ $i == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ route('movies.list', array_merge(request()->query(), ['page' => $i])) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        {{-- Next Page Link --}}
                        <li class="page-item {{ $page >= $totalPages ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ route('movies.list', array_merge(request()->query(), ['page' => $page + 1])) }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        @endif

        <div id="loading" class="text-center py-4 d-none">
            <div class="spinner-border text-primary"></div>
            <p class="text-muted mt-2">{{ trans('messages.loading_more') }}</p>
        </div>
    @else
        <div class="text-center py-5 hero-section"> {{-- Apply hero-section --}}
            <h1 class="display-4 text-primary mb-4">
                <i class="fas fa-film"></i> {{ trans('messages.welcome_to_movie_app') }}
            </h1>

            <div class="my-5">
                @if(!empty($recommendedMovies))
                    <h2 class="section-title"><span>{{ trans('messages.our_recommendations') }}</span></h2> {{-- Section Title for recommendations --}}
                    <div class="row g-4">
                        @foreach($recommendedMovies as $movie)
                            @include('movies.card', ['movie' => $movie])
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif
@endsection

@push('scripts')
<script>
$(document).ready(() => {
    const loadImages = () => {
        $('img.lazyload').each(function() {
            const img = $(this)
            if(img.data('loaded')) return

            const observer = new IntersectionObserver(([entry]) => {
                if(!entry.isIntersecting) return
                img.attr('src', img.data('src')).addClass('loaded')
                observer.disconnect()
            })

            observer.observe(this)
            img.data('loaded', true)
        })
    }

    // Hanya aktifkan infinite scroll jika tidak ada parameter search
    // Jika ada search, kita menggunakan paginasi numerik
    @if (!$search)
        let loading = false
        let currentPage = {{ $page }};
        const totalPages = {{ $totalPages }}; // Ambil totalPages dari controller

        $(window).on('scroll', () => {
            // Hentikan infinite scroll jika sudah di halaman terakhir atau sedang loading
            if (loading || currentPage >= totalPages) return;
            if ($(window).scrollTop() + $(window).height() < $(document).height() - 100) return;

            loading = true
            $('#loading').removeClass('d-none')

            currentPage++ // Tambah halaman untuk request berikutnya

            $.get("{{ route('movies.list') }}", {
                page: currentPage, // Gunakan currentPage yang sudah diincrement
                search: "{{ $search }}",
                year: "{{ $year }}",
                type: "{{ $type }}"
            }, data => {
                // Buat elemen div sementara dari data yang diterima
                const tempDiv = $('<div>').html(data);
                // Ambil hanya bagian daftar film dari data
                const newMovies = tempDiv.find('#movie-list .movie-card-col'); // Asumsi movie card dibungkus di '.movie-card-col'

                $('#movie-list').append(newMovies) // Append movie cards
                loadImages()
                loading = false
                $('#loading').addClass('d-none')
            }).fail(() => {
                loading = false;
                $('#loading').addClass('d-none');
                console.error("Failed to load more movies.");
            });
        })
    @endif

    loadImages()
})
</script>
@endpush