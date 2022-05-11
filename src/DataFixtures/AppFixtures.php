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

        $movie = new Movie();
        $movie->setTitle('American Psycho');
        $movie->setReleaseDate(new \DateTime('2000-06-27'));
        $manager->persist($movie);

        $movie = new Movie();
        $movie->setTitle('Test');
        $movie->setReleaseDate(new \DateTime('2000-06-27'));
        $manager->persist($movie);

        for ($i=0;$i<4;$i++) {
            $movie = new Movie();
            $movie->setTitle('Terminator '.strval($i));
            $movie->setReleaseDate(new \DateTime());
            $manager->persist($movie);
        }

        $manager->flush();
    }
}
