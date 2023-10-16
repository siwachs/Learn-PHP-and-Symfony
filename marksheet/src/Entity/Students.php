<?php

namespace App\Entity;

use App\Repository\StudentsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentsRepository::class)]
class Students
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $rollNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 2)]
    private ?string $class = null;

    #[ORM\Column(length: 255)]
    private ?string $session = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\Column(length: 255)]
    private ?string $fatherName = null;

    #[ORM\OneToMany(mappedBy: "student", targetEntity: Marks::class)]
    private Collection $marks;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function setClass(string $class): static
    {
        $this->class = $class;

        return $this;
    }

    public function getRollNumber(): ?int
    {
        return $this->rollNumber;
    }

    public function setRollNumber(int $rollNumber): static
    {
        $this->rollNumber = $rollNumber;

        return $this;
    }

    public function getSession(): ?string
    {
        return $this->session;
    }

    public function setSession(string $session): static
    {
        $this->session = $session;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): static
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getFatherName(): ?string
    {
        return $this->fatherName;
    }

    public function setFatherName(string $fatherName): static
    {
        $this->fatherName = $fatherName;

        return $this;
    }

    public function getMarks(): Collection
    {
        return $this->marks;
    }

    public function addMark(Marks $mark): static
    {
        $this->marks->add($mark);

        return $this;
    }

    public function removeMark(Marks $mark): static
    {
        $this->marks->remove($mark);

        return $this;
    }
}
