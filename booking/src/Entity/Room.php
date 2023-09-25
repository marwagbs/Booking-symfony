<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'room', targetEntity: RoomBed::class,  cascade:["persist","remove"],  orphanRemoval:true)]
    private Collection $roomBeds;

    #[ORM\ManyToOne(inversedBy: 'room')]
    private ?Accomodation $accomodation = null;

    public function __construct()
    {
        $this->roomBeds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, RoomBed>
     */
    public function getRoomBeds(): Collection
    {
        return $this->roomBeds;
    }

    public function addRoomBed(RoomBed $roomBed): self
    {
        if (!$this->roomBeds->contains($roomBed)) {
            $this->roomBeds->add($roomBed);
            $roomBed->setRoom($this);
        }

        return $this;
    }

    public function removeRoomBed(RoomBed $roomBed): self
    {
        if ($this->roomBeds->removeElement($roomBed)) {
            // set the owning side to null (unless already changed)
            if ($roomBed->getRoom() === $this) {
                $roomBed->setRoom(null);
            }
        }

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
