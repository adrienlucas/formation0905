<?php

namespace App\Tests;

use App\Repository\MovieRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityTest extends WebTestCase
{
    public function testMovieCreationIsNotAllowedForUnauthenticatedUser(): void
    {
        $client = static::createClient();
        $client->request('GET', '/movie/create');

        static::assertResponseRedirects('/login');
    }

    public function testMovieCreationIsNotAllowedForUnauthorizedUser(): void
    {
        $client = static::createClient();
        $unauthorizedUser = static::getContainer()
            ->get(UserRepository::class)
            ->findOneByUsername('john');
        $client->loginUser($unauthorizedUser);

        $client->request('GET', '/movie/create');
        static::assertResponseStatusCodeSame(403);
    }

    public function testMovieCreationIsAllowedForAuthorizedUser(): void
    {
        $client = static::createClient();
        $authorizedUser = static::getContainer()
            ->get(UserRepository::class)
            ->findOneByUsername('adrien');
        $client->loginUser($authorizedUser);

        $client->request('GET', '/movie/create');
        static::assertResponseIsSuccessful();
    }

    public function testMovieRemovingIsAllowedForCreator(): void
    {
        $client = static::createClient();
        $movieCreator = static::getContainer()
            ->get(UserRepository::class)
            ->findOneByUsername('adrien');
        $userCreatedMovie = static::getContainer()
            ->get(MovieRepository::class)
            ->findOneByCreatedBy($movieCreator);

        $client->loginUser($movieCreator);

        $client->request('GET', '/movie/'.$userCreatedMovie->getId().'/delete');
        static::assertResponseRedirects();

        $client->followRedirect();
        static::assertSelectorTextContains('div.alert-success', 'Movie removed !');
    }

    public function testMovieRemovingIsNotAllowedForOtherUsers(): void
    {
        $client = static::createClient();
        $movieCreator = static::getContainer()
            ->get(UserRepository::class)
            ->findOneByUsername('adrien');
        $userCreatedMovie = static::getContainer()
            ->get(MovieRepository::class)
            ->findOneByCreatedBy($movieCreator);

        $otherUser = static::getContainer()
            ->get(UserRepository::class)
            ->findOneByUsername('john');

        $client->loginUser($otherUser);

        $client->request('GET', '/movie/'.$userCreatedMovie->getId().'/delete');
        static::assertResponseStatusCodeSame(403);
    }
}
