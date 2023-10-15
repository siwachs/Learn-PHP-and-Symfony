<?php

namespace App\Controller;

use App\Entity\Students;
use App\Form\RollNumberType;
use App\Repository\StudentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class HomeController extends AbstractController
{
    private $formFactory;
    private $router;

    private $studentsRepo;
    private $entityManager;

    public function __construct(FormFactoryInterface $formFactory, RouterInterface $router, StudentsRepository $studentsRepo, EntityManagerInterface $entityManager)
    {
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->studentsRepo = $studentsRepo;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        $form = $this->formFactory->create(type: RollNumberType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $rollNumber = $data['rollNumber'];

            $student = $this->studentsRepo->find($rollNumber);
            $params = ['rollnumber' => $rollNumber];

            if ($student) {
                return new RedirectResponse($this->router->generate('app_marksheet', $params));
            } else {
                $form->addError(new FormError('No Student Found Having Roll Number: ' . $rollNumber));
            }
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
