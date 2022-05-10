<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $genre = new Genre();
        $genre->setName('Action');
        $manager->persist($genre);

        $movie = new Movie();
        $movie->setTitle('The Matrix');
        $movie->setDescription('Neo takes the red pill.');
        $movie->setReleaseDate(new \DateTime('1999-03-31'));
        $movie->setGenre($genre);
        $manager->persist($movie);

        $movie = new Movie();
        $movie->setTitle('The Matrix Reloaded');
        $movie->setDescription('Neo goes bruuuu.');
        $movie->setReleaseDate(new \DateTime('2003-05-15'));
        $movie->setGenre($genre);
        $manager->persist($movie);

        $movie = new Movie();
        $movie->setTitle('The Blues Brothers');
        $movie->setDescription('Jack and Elwood are doing music.');
        $movie->setReleaseDate(new \DateTime('1980-06-20'));
        $manager->persist($movie);

        $manager->flush();
    }
}
