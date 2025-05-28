@extends('layouts.app')

@section('content')
    <h2 class="page-title text-center mb-5 animate__animated animate__fadeInDown">
        <i class="fas fa-heart text-danger mr-3"></i> {{ trans('messages.my_favorites') }}
    </h2>

    @if (empty($favorites)) {{-- Gunakan empty() karena $favorites bisa menjadi array kosong setelah filter --}}
        <div class="empty-state text-center py-5 animate__animated animate__zoomIn">
            <i class="fas fa-bookmark fa-5x text-muted mb-4 animate__animated animate__bounce"></i>
            <h3 class="text-primary mb-3">{{ trans('messages.no_favorites_yet') }}</h3>
            <p class="lead text-muted">{{ trans('messages.start_adding_movies') }}</p>
            <a href="{{ route('movies.list') }}" class="btn btn-primary btn-lg mt-4 cta-button">
                <i class="fas fa-film mr-2"></i> {{ trans('messages.browse_movies') }}
            </a>
        </div>
    @else
        <div class="row animate__animated animate__fadeInUp" id="favorite-movie-list">
            @foreach ($favorites as $favorite)
                {{-- $favorite->movie_details sudah berisi objek dengan detail dari OMDB API --}}
                @php
                    $movieDetails = $favorite->movie_details; // Ambil properti movie_details
                @endphp
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <div class="movie-card card h-100 shadow-lg border-0 overflow-hidden animate__animated animate__slideInUp">
                        {{-- Image with Loading State --}}
                        <div class="poster-container position-relative">
                            <div class="shimmer"></div>
                            <img class="card-img-top lazyload"
                                data-src="{{ ($movieDetails->poster ?? null) && ($movieDetails->poster !== 'N/A') ? $movieDetails->poster : 'https://via.placeholder.com/300x450?text=No+Image' }}"
                                src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                alt="{{ $movieDetails->title ?? 'No Title' }}"
                                loading="lazy">

                            {{-- Badges --}}
                            @if (isset($movieDetails->imdbRating) && $movieDetails->imdbRating !== 'N/A')
                                <div class="position-relative top-0 start-0 ml-3">
                                    <span class="badge badge-pill badge-warning movie-rating-badge shadow-sm">
                                        <i class="fas fa-star mr-1"></i>{{ $movieDetails->imdbRating }}
                                    </span>
                                </div>
                            @endif
                            @if (isset($movieDetails->type) && $movieDetails->type !== 'N/A')
                                <div class="position-relative top-0 start-0 ml-3">
                                    <span class="badge badge-pill badge-info text-uppercase movie-type-badge shadow-sm">
                                        {{ $movieDetails->type }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body position-relative d-flex flex-column">
                            <h5 class="card-title font-weight-bold text-truncate text-dark mb-1">
                                {{ $movieDetails->title ?? 'N/A' }}
                            </h5>
                            <small class="d-block text-muted mb-2">{{ $movieDetails->year ?? 'N/A' }}</small>

                            <div class="genre-badges mb-3">
                                @if(isset($movieDetails->genre) && $movieDetails->genre)
                                    @foreach(explode(', ', $movieDetails->genre) as $genre)
                                        <span class="badge badge-secondary genre-badge">{{ $genre }}</span>
                                    @endforeach
                                @endif
                            </div>

                            <p class="card-text text-secondary small line-clamp-3 mb-3 flex-grow-1">
                                {{ $movieDetails->plot ?? trans('messages.no_plot_available') }}
                            </p>
                        </div>

                        {{-- Card Footer --}}
                        <div class="card-footer bg-light border-0 d-flex justify-content-between align-items-center pt-3 pb-3">
                            <a href="{{ route('movies.detail', $favorite->imdb_id) }}"
                               class="btn btn-sm btn-outline-primary movie-action-button">
                                <i class="fas fa-info-circle mr-2"></i>{{ trans('messages.details') }}
                            </a>
                            <form action="{{ route('favorites.destroy', $favorite->imdb_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger movie-action-button remove-favorite-button">
                                    <i class="fas fa-trash-alt mr-2"></i>{{ trans('messages.remove') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
    :root {
        --primary-color: #007bff; /* Vibrant Blue */
        --secondary-color: #6c757d; /* Muted Grey */
        --accent-color: #ffc107; /* Warning Yellow */
        --danger-color: #dc3545; /* Red for remove */
        --dark-text-color: #343a40; /* Dark Grey for text */
        --light-bg-color: #f8f9fa; /* Light background */
        --card-bg-gradient-start: #ffffff;
        --card-bg-gradient-end: #f0f2f5;
        --shimmer-bg-start: rgba(255, 255, 255, 0);
        --shimmer-bg-middle: rgba(255, 255, 255, 0.4);
        --shimmer-bg-end: rgba(255, 255, 255, 0);
    }

    body {
        background-color: var(--light-bg-color);
        font-family: 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    .page-title {
        font-weight: 800;
        color: var(--dark-text-color);
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.05);
    }

    /* Movie Card Enhancements (Copied from previous example for consistency) */
    .movie-card {
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        border-radius: 15px;
        background: linear-gradient(145deg, var(--card-bg-gradient-start), var(--card-bg-gradient-end));
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .movie-card:hover {
        transform: translateY(-12px) scale(1.03);
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.2);
    }

    .poster-container {
        height: 380px;
        overflow: hidden;
        position: relative;
        background: #f0f0f0;
        border-radius: 15px 15px 0 0;
    }

    .poster-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .movie-card:hover .poster-container img {
        transform: scale(1.05);
    }

    .shimmer {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(
            90deg,
            var(--shimmer-bg-start) 0%,
            var(--shimmer-bg-middle) 50%,
            var(--shimmer-bg-end) 100%
        );
        animation: shimmer 1.8s infinite cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    .movie-card .card-img-top.lazyload {
        opacity: 0;
        transition: opacity 0.5s ease;
    }

    .movie-card .card-img-top.lazyload.loaded {
        opacity: 1;
    }

    .movie-rating-badge {
        background-color: var(--accent-color) !important;
        font-size: 0.95rem;
        padding: 0.5em 0.8em;
        border-radius: 0.5rem;
    }

    .movie-type-badge {
        background-color: var(--primary-color) !important;
        font-size: 0.95rem;
        padding: 0.5em 0.8em;
        border-radius: 0.5rem;
    }

    .genre-badge {
        background-color: var(--secondary-color);
        color: white;
        padding: 0.3em 0.6em;
        border-radius: 5px;
        margin-right: 5px;
        margin-bottom: 5px;
        display: inline-block;
        font-size: 0.85rem;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .movie-action-button {
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .movie-action-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }

    /* Custom remove button styling */
    .remove-favorite-button {
        background-color: var(--danger-color);
        border-color: var(--danger-color);
        color: white;
    }

    .remove-favorite-button:hover {
        background-color: darken(var(--danger-color), 10%);
        border-color: darken(var(--danger-color), 10%);
    }

    /* Empty State */
    .empty-state {
        padding: 4rem 0;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        border: 1px dashed #ced4da;
    }

    .empty-state i {
        color: #adb5bd !important;
    }

    /* Call-to-action button for empty state */
    .cta-button {
        border-radius: 30px;
        padding: 0.9rem 2.5rem;
        font-size: 1.1rem;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .cta-button.btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .cta-button.btn-primary:hover {
        background-color: darken(var(--primary-color), 10%);
        border-color: darken(var(--primary-color), 10%);
        transform: translateY(-3px);
    }

    /* Animate.css adjustments */
    .animate__animated {
        --animate-duration: 0.8s;
    }
    .animate__slideInUp {
        --animate-delay: 0.2s;
    }
    .animate__fadeIn {
        --animate-delay: 0.1s;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        function initializeAndLoadImages() {
            $('img.lazyload').each(function() {
                var $img = $(this);
                if ($img.hasClass('loaded')) {
                    return;
                }

                var imageUrl = $img.data('src');

                if (imageUrl && imageUrl.trim() !== '' && imageUrl !== 'N/A' && imageUrl.indexOf('placeholder') === -1) {
                    if ('IntersectionObserver' in window) {
                        var observer = new IntersectionObserver(function(entries, observer) {
                            entries.forEach(function(entry) {
                                if (entry.isIntersecting) {
                                    var lazyImage = entry.target;
                                    var tempImage = new Image();
                                    tempImage.onload = function() {
                                        lazyImage.src = imageUrl;
                                        $(lazyImage).addClass('loaded');
                                        $(lazyImage).closest('.poster-container').find('.shimmer').remove();
                                    };
                                    tempImage.onerror = function() {
                                        console.error('Error loading image (IntersectionObserver):', imageUrl);
                                        lazyImage.src = 'https://via.placeholder.com/300x450?text=Image+Load+Error';
                                        $(lazyImage).addClass('loaded');
                                        $(lazyImage).closest('.poster-container').find('.shimmer').remove();
                                    };
                                    tempImage.src = imageUrl;
                                    observer.unobserve(lazyImage);
                                }
                            });
                        }, {
                            rootMargin: '0px 0px 200px 0px'
                        });
                        observer.observe(this);
                    } else {
                        // Fallback for older browsers
                        var tempImage = new Image();
                        tempImage.onload = function() {
                            $img.attr('src', imageUrl);
                            $img.addClass('loaded');
                            $img.closest('.poster-container').find('.shimmer').remove();
                        };
                        tempImage.onerror = function() {
                            console.error('Error loading image (Fallback/Direct):', imageUrl);
                            $img.attr('src', 'https://via.placeholder.com/300x450?text=Image+Load+Error');
                            $img.addClass('loaded');
                            $img.closest('.poster-container').find('.shimmer').remove();
                        };
                        tempImage.src = imageUrl;
                    }
                } else {
                    // If data-src is invalid, N/A, or placeholder
                    $img.attr('src', 'https://via.placeholder.com/300x450?text=No+Image');
                    $img.addClass('loaded');
                    $img.closest('.poster-container').find('.shimmer').remove();
                }
            });
        }

        initializeAndLoadImages();
    });

    document.addEventListener("DOMContentLoaded", function () {
        const lazyImages = document.querySelectorAll(".lazyload");

        lazyImages.forEach(img => {
            img.addEventListener("load", function () {
                img.classList.add("loaded");
            });
        });
    });
</script>
@endpush