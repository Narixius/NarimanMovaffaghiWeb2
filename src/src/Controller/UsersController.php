<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/users', name: 'app_users')]
    public function index(UserRepository $userRepository): Response
    {

        return $this->render('users/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
}
