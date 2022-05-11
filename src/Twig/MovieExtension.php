<?php

namespace App\Twig;

use App\Entity\Movie;
use App\ThirdPartyApi\OmdbGateway;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MovieExtension extends AbstractExtension
{
    private OmdbGateway $omdbGateway;

    public function __construct(OmdbGateway $omdbGateway)
    {
        $this->omdbGateway = $omdbGateway;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('omdb_get_poster', [$this, 'omdbGetPoster']),
        ];
    }

    public function omdbGetPoster(Movie $movie): string
    {
        return $this->omdbGateway->getPosterByMovie($movie);
    }

}
