<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Security;

class AuthController extends AbstractController
{
    private $router;
    private $formFactory;
    private $passwordHasher;
    private $entityManager;

    private $authUtils;
    private $user;

    function __construct(RouterInterface $router, FormFactoryInterface $formFactory, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager, AuthenticationUtils $authUtils, Security $security)
    {
        $this->router = $router;
        $this->formFactory = $formFactory;
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
        $this->authUtils = $authUtils;
        $this->user = $security->getUser();
    }

    #[Route('/signup', name: 'app_signup')]
    public function signUp(Request $request): Response
    {
        if ($this->user) {
            return new RedirectResponse($this->router->generate('app_home'));
        }

        $user = new User();
        $form = $this->formFactory->create(type: RegistrationType::class, data: $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plaintextPassword = $user->getPassword();
            $hashedPassword = $this->passwordHasher->hashPassword(
                $user,
                $plaintextPassword
            );
            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_USER']);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return new RedirectResponse($this->router->generate('app_signin'));
        }

        return $this->render('auth/signup.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/signin', name: 'app_signin')]
    public function signIn(): Response
    {
        if ($this->user) {
            return new RedirectResponse($this->router->generate('app_home'));
        }

        $error = $this->authUtils->getLastAuthenticationError();
        $lastUsername = $this->authUtils->getLastUsername();

        return $this->render('auth/signin.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/signout', name: 'app_signout', methods: ['GET'])]
    public function logout(): never
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
