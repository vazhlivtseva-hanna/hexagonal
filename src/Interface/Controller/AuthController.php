<?php

namespace App\Interface\Controller;

use App\Application\User\Command\LoginUserCommand;
use App\Application\User\Command\RegisterUserCommand;
use App\Application\User\Handler\LoginUserHandler;
use App\Application\User\Handler\RegisterUserHandler;
use App\Domain\User\Entity\User;
use App\Interface\Http\Form\RegistrationForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        RegisterUserHandler $handler
    ): Response
    {
        $form = $this->createForm(RegistrationForm::class, null);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $plainPassword = $form->get('plainPassword')->getData();

            $command = new RegisterUserCommand($email, $plainPassword);

            try {
                ($handler)($command);
            } catch (\DomainException $e) {
                $this->addFlash('error', $e->getMessage());
                return $this->redirectToRoute('app_register');
            }

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route(path: '/login', name: 'app_login', methods: ['GET'])]
    public function showLoginForm(): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('security/login.html.twig', [
            'error' => null
        ]);
    }

    #[Route(path: '/login', name: 'app_login_post', methods: ['POST'])]
    public function handleLogin(Request $request, LoginUserHandler $handler): Response
    {
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        try {
            $command = new LoginUserCommand($email, $password);
            ($handler)($command);

            return $this->redirectToRoute('dashboard');
        } catch (\Exception $e) {
            return $this->render('security/login.html.twig', [
                'error' => $e->getMessage()
            ]);
        }
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
