<?php

namespace App\Entity;

use App\Repository\BedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BedRepository::class)]
class Bed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $size = null;

    #[ORM\OneToMany(mappedBy: 'bed', targetEntity: RoomBed::class)]
    private Collection $roomBed;

    public function __construct()
    {
        $this->roomBed = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return Collection<int, RoomBed>
     */
    public function getRoomBed(): Collection
    {
        return $this->roomBed;
    }

    public function addRoomBed(RoomBed $roomBed): self
    {
        if (!$this->roomBed->contains($roomBed)) {
            $this->roomBed->add($roomBed);
            $roomBed->setBed($this);
        }

        return $this;
    }

    public function removeRoomBed(RoomBed $roomBed): self
    {
        if ($this->roomBed->removeElement($roomBed)) {
            // set the owning side to null (unless already changed)
            if ($roomBed->getBed() === $this) {
                $roomBed->setBed(null);
            }
        }

        return $this;
    }
    public function  __toString(){
        return $this->name;
    }
}
