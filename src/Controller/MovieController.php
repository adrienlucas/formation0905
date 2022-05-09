<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/movie", name="app_movie")
     */
    public function index(): Response
    {
        $movie = [
            'title' => 'The Matrix',
            'description' => 'Neo takes the red pill.',
            'release_date' => new \DateTime('1999-03-31'),
        ];

        return new Response(
            '<html><body><h2>'.$movie['title'].
            '</h2><strong>'.$movie['release_date']->format('d/m/Y').
            '</strong><p>'.$movie['description'].
            '</p></body></html>');
    }
}
