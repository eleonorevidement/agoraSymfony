<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\UserRepository;  // Import UserRepository

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(UserRepository $userRepository): Response
    {
        // Assuming you fetch the currently logged-in user
        $user = $userRepository->find($this->getUser()->getId());

        return $this->render('account/index.html.twig', [
            'user' => $user,
        ]);
    }
}

