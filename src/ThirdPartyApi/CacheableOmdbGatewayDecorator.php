<?php
declare(strict_types=1);

namespace App\ThirdPartyApi;

use App\Entity\Movie;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Contracts\Cache\CacheInterface;

class CacheableOmdbGatewayDecorator extends OmdbGateway
{
    private CacheInterface $cachePool;
    private OmdbGateway $actualGateway;

    public function __construct(CacheInterface $cachePool, OmdbGateway $actualGateway)
    {
        $this->cachePool = $cachePool;
        $this->actualGateway = $actualGateway;
    }

    public function getDescriptionByMovie(Movie $movie): string
    {
        return $this->actualGateway->getDescriptionByMovie($movie);
    }

    public function getPosterByMovie(Movie $movie): string
    {
        return $this->cachePool->get(
            'poster_'.$movie->getId(),
            function() use ($movie) {
                return $this->actualGateway->getPosterByMovie($movie);
            }
        );
    }
}