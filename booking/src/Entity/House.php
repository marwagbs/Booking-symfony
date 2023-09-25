<?php

namespace App\Entity;

use App\Repository\HouseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HouseRepository::class)]
class House extends Accomodation
{
   
   

    #[ORM\Column]
    private ?int $garage = null;

    #[ORM\Column]
    private ?int $pool = null;

   

    public function getGarage(): ?int
    {
        return $this->garage;
    }

    public function setGarage(int $garage): self
    {
        $this->garage = $garage;

        return $this;
    }

    public function getPool(): ?int
    {
        return $this->pool;
    }

    public function setPool(int $pool): self
    {
        $this->pool = $pool;

        return $this;
    }
}
