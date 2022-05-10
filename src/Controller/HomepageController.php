<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     * @Route("/hello/{name}", name="app_greetings")
     */
    public function index(?string $name = null, MovieRepository $movieRepository): Response
    {
        $movie = $movieRepository->findRandom();

        return $this->render('index.html.twig', [
            'name' => $name ?? 'world',
            'promoted_movie' => $movie
        ]);
//            return new Response('<html><body><h1>Hello ' . ($name ?? 'world') . ' !</h1></body></html>');
//        return $this->json([
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/HomepageController.php',
//        ]);
    }
}
