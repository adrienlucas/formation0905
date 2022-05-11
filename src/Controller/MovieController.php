<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    /**
     * @Route("/movie/{id}", name="app_movie_detail", requirements={"id": "\d+"})
     */
    public function index(Movie $movie): Response
    {
        return $this->render('movie/detail.html.twig', [
            'movie' => $movie,
        ]);
    }

    /**
     * @Route("/movie/list", name="app_movie_list")
     */
    public function list(MovieRepository $movieRepository): Response
    {
        $movies = $movieRepository->findAll();

        return $this->render('movie/list.html.twig', [
            'movies' => $movies,
        ]);
    }

    /**
     * @Route("/movie/create", name="app_movie_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $movieCreationForm = $this->createForm(MovieType::class);

        $movieCreationForm->add('create', SubmitType::class);

        $movieCreationForm->handleRequest($request);

        if($movieCreationForm->isSubmitted() && $movieCreationForm->isValid()) {
            $movie = $movieCreationForm->getData();

            $entityManager->persist($movie);
            $entityManager->flush();

            $this->addFlash('success', 'Movie created !');

            return $this->redirectToRoute('app_movie_list');
        }

        return $this->render('movie/create.html.twig', [
            'movieCreationForm' => $movieCreationForm->createView(),
        ]);
    }


}
