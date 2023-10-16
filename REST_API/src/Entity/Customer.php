<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    #[ORM\Id]
    #[Assert\Email]
    #[ORM\Column(length: 100)]
    private ?string $email = null;

    #[ORM\Column(length: 22)]
    #[Assert\Length(
        min: 6
    )]
    #[Assert\NotBlank]
    private ?string $phoneNumber = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Cart $cart = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): static
    {
        $this->cart = $cart;

        return $this;
    }
}
