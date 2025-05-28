<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Entities\Movie;
use App\Models\Favorite;
use Illuminate\Support\Facades\Log; // Pastikan ini diimpor

class MovieController extends Controller
{
    protected $client;
    protected $apiKey;
    protected $perPage = 10; // Jumlah hasil per halaman dari OMDb API

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'http://www.omdbapi.com/']);
        $this->apiKey = config('services.omdb.key');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $year = $request->input('year');
        $type = $request->input('type');
        $page = $request->input('page', 1);
        $movies = [];
        $totalResults = 0;
        $recommendedMovies = [];

        if ($search) {
            try {
                $response = $this->client->get('/', [
                    'query' => [
                        'apikey' => $this->apiKey,
                        's' => $search,
                        'y' => $year,
                        'type' => $type,
                        'page' => $page
                    ]
                ]);

                $data = json_decode($response->getBody()->getContents(), true);

                if ($data['Response'] == 'True') {
                    foreach ($data['Search'] as $movieData) {
                        // Ambil data detail untuk setiap film hasil pencarian
                        $detailResponse = $this->client->get('/', [
                            'query' => [
                                'apikey' => $this->apiKey,
                                'i' => $movieData['imdbID']
                            ]
                        ]);

                        $detailData = json_decode($detailResponse->getBody()->getContents(), true);

                        if ($detailData['Response'] == 'True') {
                            $movies[] = Movie::createFromApiResponse($detailData);
                        }
                    }
                    $totalResults = (int)$data['totalResults']; // Pastikan ini integer
                }
            } catch (\Exception $e) {
                Log::error("OMDb API search error: " . $e->getMessage());
                // Anda bisa mengembalikan pesan error ke view jika perlu
            }
        } else {
            $popularSearches = ['Action', 'Drama', 'Comedy', 'Thriller', 'Horror', 'Sci-Fi'];
            $tempRecommendations = [];

            foreach ($popularSearches as $term) {
                try {
                    $response = $this->client->get('/', [
                        'query' => [
                            'apikey' => $this->apiKey,
                            's' => $term,
                            'type' => 'movie',
                            'page' => 1
                        ]
                    ]);
                    $data = json_decode($response->getBody()->getContents(), true);

                    if ($data['Response'] == 'True' && !empty($data['Search'])) {
                        foreach (array_slice($data['Search'], 0, 2) as $movieData) {
                            $detailResponse = $this->client->get('/', [
                                'query' => [
                                    'apikey' => $this->apiKey,
                                    'i' => $movieData['imdbID']
                                ]
                            ]);

                            $detailData = json_decode($detailResponse->getBody()->getContents(), true);

                            if ($detailData['Response'] == 'True') {
                                if (!isset($tempRecommendations[$detailData['imdbID']])) {
                                    $tempRecommendations[$detailData['imdbID']] = Movie::createFromApiResponse($detailData);
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::error("OMDb API recommendation error for term '{$term}': " . $e->getMessage());
                }
            }
            $recommendedMovies = array_slice(array_values($tempRecommendations), 0, 8);
        }

        if (empty($movies) && $search) {
            return view('movies.list')->with('no_results', trans('messages.no_results'));
        }

        // Hitung total halaman
        $totalPages = ($totalResults > 0) ? ceil($totalResults / $this->perPage) : 0;

        return view('movies.list', compact('movies', 'search', 'year', 'type', 'page', 'totalResults', 'totalPages', 'recommendedMovies'));
    }

    public function show($imdbId)
    {
        $response = $this->client->get('/', [
            'query' => [
                'apikey' => $this->apiKey,
                'i' => $imdbId,
                'plot' => 'full'
            ]
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        if ($data['Response'] == 'False') {
            abort(404, trans('messages.movie_not_found'));
        }

        $movie = Movie::createFromApiResponse($data);

        // Pastikan pengguna login sebelum mencoba mengakses favorites
        $isFavorite = false;
        if (auth()->check()) {
            $isFavorite = auth()->user()->favorites()->where('imdb_id', $imdbId)->exists();
        }

        return view('movies.detail', compact('movie', 'isFavorite'));
    }
}