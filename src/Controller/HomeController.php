<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController {

    #[Route("/", name: "home")]//chaque page correspond a une route donc par exemple ici c'est notre page principale
    function index(Request $request): Response {

        return new Response('Bienvenue sur Agora');
    }

}
