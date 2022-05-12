<?php
declare(strict_types=1);

namespace App\ThirdPartyApi;

use App\Entity\Movie;
use Psr\Log\LoggerInterface;

class LogguableOmdbGatewayDecorator extends OmdbGateway
{
    private OmdbGateway $actualGateway;
    private LoggerInterface $logger;

    public function __construct(OmdbGateway $actualGateway, LoggerInterface $logger)
    {
        $this->actualGateway = $actualGateway;
        $this->logger = $logger;
    }

    public function getPosterByMovie(Movie $movie): string
    {
        $this->logger->notice('A poster has been requested.');
        return $this->actualGateway->getPosterByMovie($movie);
    }

    public function getDescriptionByMovie(Movie $movie): string
    {
        $this->logger->notice('A description has been requested.');
        return $this->actualGateway->getDescriptionByMovie($movie);
    }
}