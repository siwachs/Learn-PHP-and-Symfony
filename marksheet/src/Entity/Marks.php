<?php

namespace App\Entity;

use App\Repository\MarksRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarksRepository::class)]
class Marks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    #[ORM\Column]
    private ?int $totalMarks = null;

    #[ORM\Column]
    private ?int $passingMarks = null;

    #[ORM\Column]
    private ?int $obtainedMarks = null;

    #[ORM\Column(length: 1)]
    private ?string $grade = null;

    #[ORM\ManyToOne(inversedBy: "marks", targetEntity: Students::class)]
    #[ORM\JoinColumn(name: "roll_number", referencedColumnName: "roll_number")]
    private ?Students $student = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getTotalMarks(): ?int
    {
        return $this->totalMarks;
    }

    public function setTotalMarks(int $totalMarks): static
    {
        $this->totalMarks = $totalMarks;

        return $this;
    }

    public function getPassingMarks(): ?int
    {
        return $this->passingMarks;
    }

    public function setPassingMarks(int $passingMarks): static
    {
        $this->passingMarks = $passingMarks;

        return $this;
    }

    public function getObtainedMarks(): ?int
    {
        return $this->obtainedMarks;
    }

    public function setObtainedMarks(int $obtainedMarks): static
    {
        $this->obtainedMarks = $obtainedMarks;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): static
    {
        $this->grade = $grade;

        return $this;
    }

    public function getStudent(): ?Students
    {
        return $this->student;
    }

    public function setStudent(?Students $student): static
    {
        $this->student = $student;

        return $this;
    }
}
