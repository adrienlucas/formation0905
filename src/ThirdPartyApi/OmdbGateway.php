<?php
declare(strict_types=1);

namespace App\ThirdPartyApi;

use App\Entity\Movie;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class OmdbGateway
{
    private HttpClientInterface $httpClient;
    private string $omdbApiKey;

    public function __construct(HttpClientInterface $httpClient, string $omdbApiKey)
    {
        $this->httpClient = $httpClient;
        $this->omdbApiKey = $omdbApiKey;
    }

    public function getPosterByMovie(Movie $movie): string
    {
        $apiUrl = sprintf(
            'https://www.omdbapi.com/?apikey=%s&t=%s',
            $this->omdbApiKey,
            urlencode($movie->getTitle()),
        );
        $apiResponseContent = $this->httpClient->request('GET', $apiUrl);

        return $apiResponseContent->toArray()['Poster'] ?? '';
    }

    public function getDescriptionByMovie(Movie $movie): string
    {
        $apiUrl = sprintf(
            'https://www.omdbapi.com/?apikey=%s&t=%s',
            $this->omdbApiKey,
            urlencode($movie->getTitle()),
        );
        $apiResponseContent = $this->httpClient->request('GET', $apiUrl);

        return $apiResponseContent->toArray()['Plot'] ?? '';
    }
}