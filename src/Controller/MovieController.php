<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieType;
use App\Repository\MovieRepository;
use App\ThirdPartyApi\OmdbGateway;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    private OmdbGateway $omdbGateway;
    private MovieRepository $movieRepository;

    public function __construct(OmdbGateway $omdbGateway, MovieRepository $movieRepository)
    {
        $this->omdbGateway = $omdbGateway;
        $this->movieRepository = $movieRepository;
    }

    /**
     * @Route("/movie/{id}", name="app_movie_detail", requirements={"id": "\d+"})
     */
    public function index(Movie $movie): Response
    {
//        $moviePoster = $this->omdbGateway->getPosterByMovie($movie);

        return $this->render('movie/detail.html.twig', [
            'movie' => $movie,
//            'movie_poster' => $moviePoster
        ]);
    }

    /**
     * @Route("/movie/list", name="app_movie_list")
     */
    public function list(): Response
    {
        $movies = $this->movieRepository->findAll();

        return $this->render('movie/list.html.twig', [
            'movies' => $movies,
        ]);
    }

    /**
     * @Route("/movie/create", name="app_movie_create")
     * @IsGranted("ROLE_CONTRIB_MOVIES")
     */
    public function create(Request $request): Response
    {
        $movieCreationForm = $this->createForm(MovieType::class);

        $movieCreationForm->add('create', SubmitType::class);

        $movieCreationForm->handleRequest($request);

        if($movieCreationForm->isSubmitted() && $movieCreationForm->isValid()) {
            $movie = $movieCreationForm->getData();
            $this->movieRepository->add($movie, true);

            $this->addFlash('success', 'Movie created !');

            return $this->redirectToRoute('app_movie_list');
        }

        return $this->render('movie/create.html.twig', [
            'movieCreationForm' => $movieCreationForm->createView(),
        ]);
    }

    /**
     * @Route("/movie/{id}/delete", name="app_movie_delete")
     */
    public function delete(Movie $movie)
    {
        $this->movieRepository->remove($movie, true);

        $this->addFlash('success', 'Movie removed !');

        return $this->redirectToRoute('app_movie_list');
    }
}
