<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use App\Entity\Movie;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

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

        $user = new User();
        $user->setUsername('adrien');
        $user->setRoles(['ROLE_CONTRIB_MOVIES']);
        $user->setPassword($this->encoder->hashPassword($user, 'adrien'));
        $manager->persist($user);

        $user = new User();
        $user->setUsername('john');
        $user->setRoles([]);
        $user->setPassword($this->encoder->hashPassword($user, 'john'));
        $manager->persist($user);

        $manager->flush();
    }
}
