<?php

namespace Application\Seeder;

use Application\Entity\Movies;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Client;

class MovieSeeder
{
    private $entityManager;
    private $client;
    private $apiKey;
    private $accessToken;
    private $imageBaseUrl = 'https://image.tmdb.org/t/p/w500';

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->client = new Client();
        $this->apiKey = '6b7e944fa554e9625af5a79b7b786422';
        $this->accessToken = 'eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiI2YjdlOTQ0ZmE1NTRlOTYyNWFmNWE3OWI3Yjc4NjQyMiIsInNiZiI6MTcyMzkxMDgyMi42NzQzMTIsInN1YiI6IjY2YzBiMmUyZjlhODM4MjllMGQzMjc0MCIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.LDVD3VO1ZUxxD2h_sKR9mO4jWHlJ6ySNzEjACMsKIi8';
    }

    public function seed()
    {
        try {
            $this->entityManager->createQuery('DELETE FROM Application\Entity\Movies')->execute();
            $this->entityManager->flush();

            $movies = [];
            for ($page = 1; $page <= 2; $page++) {
                $response = $this->client->request('GET', 'https://api.themoviedb.org/3/movie/popular', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->accessToken,
                        'accept' => 'application/json',
                    ],
                    'query' => [
                        'api_key' => $this->apiKey,
                        'page' => $page,
                    ],
                ]);

                $data = json_decode($response->getBody(), true);
                $movies = array_merge($movies, $data['results']);
            }

            $count = 0;
            foreach ($movies as $movieData) {
                if ($count >= 32) break;

                if (!isset($movieData['title']) || !isset($movieData['release_date']) || !isset($movieData['poster_path'])) {
                    continue;
                }

                $movie = new Movies();
                $movie->setTitle($movieData['title']);
                $movie->setReleaseYear(date('Y', strtotime($movieData['release_date'])));

                $fullImageUrl = $this->imageBaseUrl . $movieData['poster_path'];
                $movie->setImage($fullImageUrl);

                $randomLength = mt_rand(100, 250) / 100;
                $movie->setMovieLength($randomLength);

                $this->entityManager->persist($movie);
                $count++;
            }

            $this->entityManager->flush();
        } catch (\Exception $e) {
        }
    }
}