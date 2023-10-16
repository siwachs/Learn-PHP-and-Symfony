<?php

namespace App\Controller;

use App\Repository\StudentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MarksheetController extends AbstractController
{
    private $studentsRepo;

    public function __construct(StudentsRepository $studentsRepo)
    {
        $this->studentsRepo = $studentsRepo;
    }

    #[Route('/marksheet/{rollnumber}', name: 'app_marksheet')]
    public function index($rollnumber): Response
    {
        $student = $this->studentsRepo->find($rollnumber);

        if ($student) {
            $marks = $student->getMarks();
            return $this->render('marksheet/index.html.twig', [
                'student' => $student,
                'marks' => $marks,
            ]);
        } else {
            return $this->render('marksheet/404.html.twig', [
                'student' => $student,
            ]);
        }
    }
}
