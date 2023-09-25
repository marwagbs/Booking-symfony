<?php

namespace App\Entity;

use App\Repository\BoatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoatRepository::class)]
class Boat extends Accomodation
{
   
    
   

    #[ORM\Column]
    private ?int $roofHeight = null;

    #[ORM\Column]
    private ?int $motor = null;

    #[ORM\Column]
    private ?bool $isMoving = null;

    
    public function getRoofHeight(): ?int
    {
        return $this->roofHeight;
    }

    public function setRoofHeight(int $roofHeight): self
    {
        $this->roofHeight = $roofHeight;

        return $this;
    }

    public function getMotor(): ?int
    {
        return $this->motor;
    }

    public function setMotor(int $motor): self
    {
        $this->motor = $motor;

        return $this;
    }

    public function isIsMoving(): ?bool
    {
        return $this->isMoving;
    }

    public function setIsMoving(bool $isMoving): self
    {
        $this->isMoving = $isMoving;

        return $this;
    }
}
