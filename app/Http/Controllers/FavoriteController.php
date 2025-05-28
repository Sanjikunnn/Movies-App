<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Favorite;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException; // Tambahkan ini untuk menangani error Guzzle

class FavoriteController extends Controller
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'http://www.omdbapi.com/']);
        $this->apiKey = config('services.omdb.key');
    }

    public function index()
    {
        $userFavorites = auth()->user()->favorites()->get();
        $favoritesWithDetails = [];

        foreach ($userFavorites as $favorite) {
            try {
                $response = $this->client->get('/', [
                    'query' => [
                        'apikey' => $this->apiKey,
                        'i' => $favorite->imdb_id, // Menggunakan imdb_id dari database
                        'plot' => 'short'
                    ]
                ]);
                $movieData = json_decode($response->getBody()->getContents(), true);

                if (isset($movieData['Response']) && $movieData['Response'] == 'True') {
                    // Tambahkan data OMDB langsung ke objek favorit
                    $favorite->movie_details = (object)[ // Buat properti baru untuk detail
                        'title' => $movieData['Title'] ?? 'Untitled',
                        'poster' => ($movieData['Poster'] ?? null) !== 'N/A' ? $movieData['Poster'] : null,
                        'year' => $movieData['Year'] ?? 'Unknown',
                        'genre' => $movieData['Genre'] ?? '',
                        'imdbRating' => $movieData['imdbRating'] ?? 'N/A',
                        'type' => $movieData['Type'] ?? 'N/A',
                        'plot' => $movieData['Plot'] ?? 'N/A',
                    ];
                } else {
                    // Jika film tidak ditemukan di OMDB (misal: ID tidak valid)
                    $favorite->movie_details = (object)[
                        'title' => 'Movie Not Found',
                        'poster' => null, // Placeholder akan digunakan
                        'year' => 'N/A',
                        'genre' => '',
                        'imdbRating' => 'N/A',
                        'type' => 'N/A',
                        'plot' => 'Details could not be retrieved from OMDb.',
                    ];
                }
            } catch (RequestException $e) {
                // Tangani error Guzzle (misal: API tidak bisa dijangkau)
                \Log::error("OMDB API request failed for IMDb ID {$favorite->imdb_id}: " . $e->getMessage());
                $favorite->movie_details = (object)[
                    'title' => 'API Error',
                    'poster' => null,
                    'year' => 'N/A',
                    'genre' => '',
                    'imdbRating' => 'N/A',
                    'type' => 'N/A',
                    'plot' => 'Could not retrieve movie details due to an API error.',
                ];
            }
            $favoritesWithDetails[] = $favorite;
        }

        // Kirim array $favoritesWithDetails ke view
        return view('favorites.index', ['favorites' => $favoritesWithDetails]);
    }

    public function store(Request $request)
    {
        $imdbId = $request->input('imdb_id');

        // Prevent duplicate favorites for the same user
        if (auth()->user()->favorites()->where('imdb_id', $imdbId)->exists()) {
            return back()->with('error', trans('messages.already_favorite'));
        }

        // Tidak perlu mengambil semua data film di sini, cukup simpan imdb_id
        // Data lengkap akan diambil saat menampilkan daftar favorit
        auth()->user()->favorites()->create([
            'imdb_id' => $imdbId,
            // movie_data akan kosong atau null jika Anda tidak ingin menyimpannya
            'movie_data' => json_encode([]) // Simpan JSON kosong atau null
        ]);

        return back()->with('success', trans('messages.favorite_added'));
    }

    public function destroy($imdbId)
    {
        auth()->user()->favorites()->where('imdb_id', $imdbId)->delete();
        return back()->with('success', trans('messages.favorite_removed'));
    }
}