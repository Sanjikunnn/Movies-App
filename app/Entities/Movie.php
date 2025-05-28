<?php

namespace App\Entities;

class Movie
{
    public $imdbID;
    public $title;
    public $year;
    public $type;
    public $poster;
    public $plot;
    public $genre;
    public $director;
    public $actors;
    public $imdbRating;
    public $awards;
    public $boxOffice;

    public function __construct(
        $imdbID,
        $title,
        $year,
        $type,
        $poster,
        $plot = null,
        $genre = null,
        $director = null,
        $actors = null,
        $imdbRating = null,
        $awards = null,
        $boxOffice = null
    ) {
        $this->imdbID = $imdbID;
        $this->title = $title;
        $this->year = $year;
        $this->type = $type;
        $this->poster = $poster;
        $this->plot = $plot;
        $this->genre = $genre;
        $this->director = $director;
        $this->actors = $actors;
        $this->imdbRating = $imdbRating;
        $this->awards = $awards;
        $this->boxOffice = $boxOffice;
    }

    /**
     * Membuat objek Movie dari array respons API OMDb.
     * @param array $data Respons JSON dari OMDb API.
     * @return Movie
     */
    public static function createFromApiResponse(array $data)
    {
        return new self(
            $data['imdbID'] ?? null,
            $data['Title'] ?? null,
            $data['Year'] ?? null,
            $data['Type'] ?? null,
            ($data['Poster'] ?? 'N/A') === 'N/A' ? null : $data['Poster'], // Handle 'N/A' poster
            $data['Plot'] ?? null,
            $data['Genre'] ?? null,
            $data['Director'] ?? null,
            $data['Actors'] ?? null,
            $data['imdbRating'] ?? 'N/A',
            $data['Awards'] ?? null,
            $data['BoxOffice'] ?? null
        );
    }

    /**
     * Mengembalikan URL poster, atau placeholder jika tidak ada.
     * @return string
     */
    public function getPosterUrl()
    {
        return $this->poster ?: 'https://via.placeholder.com/300x450?text=No+Image';
    }
}