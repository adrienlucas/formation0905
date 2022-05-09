<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     * @Route("/hello/{name}", name="app_greetings")
     */
    public function index(?string $name = null): Response
    {

//        return $this->render('index.html.twig', []);
        return new Response('<html><body>Hello '.($name ?? 'world').' !</body></html>');
//        return $this->json([
//            'message' => 'Welcome to your new controller!',
//            'path' => 'src/Controller/HomepageController.php',
//        ]);
    }
}
