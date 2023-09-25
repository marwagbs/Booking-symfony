<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BookingRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\GreaterThan('today UTC')]
    private ?\DateTimeImmutable $startDateAt = null;

    #[ORM\Column]
    #[Assert\GreaterThan(propertyPath:"startDateAt", message:"Error")]
    private ?\DateTimeImmutable $endDateAt = null;

    #[ORM\Column]
    private ?int $nbCustomer = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?Accomodation $accomodation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDateAt(): ?\DateTimeImmutable
    {
        return $this->startDateAt;
    }

    public function setStartDateAt(\DateTimeImmutable $startDateAt): self
    {
        $this->startDateAt = $startDateAt;

        return $this;
    }

    public function getEndDateAt(): ?\DateTimeImmutable
    {
        return $this->endDateAt;
    }

    public function setEndDateAt(\DateTimeImmutable $endDateAt): self
    {
        $this->endDateAt = $endDateAt;

        return $this;
    }

    public function getNbCustomer(): ?int
    {
        return $this->nbCustomer;
    }

    public function setNbCustomer(int $nbCustomer): self
    {
        $this->nbCustomer = $nbCustomer;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAccomodation(): ?Accomodation
    {
        return $this->accomodation;
    }

    public function setAccomodation(?Accomodation $accomodation): self
    {
        $this->accomodation = $accomodation;

        return $this;
    }
}
