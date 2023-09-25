<?php

namespace App\Entity;

use App\Repository\ApartementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApartementRepository::class)]
class Apartement extends Accomodation
{
   
   
   

    #[ORM\Column]
    private ?int $floor = null;

   

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }
}
