<?php

namespace App\Interface\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'homepage')]
    public function index(TokenStorageInterface $tokenStorage): RedirectResponse
    {
        $user = $tokenStorage->getToken()?->getUser();
        if ($user && $user !== 'anon.') {
            return $this->redirectToRoute('dashboard');
        }

        return $this->redirectToRoute('app_register');
    }
}
