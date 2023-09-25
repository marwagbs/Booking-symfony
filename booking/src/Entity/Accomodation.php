<?php

namespace App\Entity;

use App\Repository\AccomodationRepository;
use Doctrine\Common\Cache\Cache;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
//choix entre JOINED ou SINGLE_TABLE
#[ORM\InheritanceType("JOINED")] 
//nom de la colonne créée pour les liaisons entre Mère et Fille
#[ORM\DiscriminatorColumn(name:"placeType", type:"string")]
//quelles classes Filles sont acceptées ?
#[ORM\DiscriminatorMap(["treeHouse" => TreeHouse::class, "house" => House::class, "apartement" => Apartement::class, "boat" => Boat::class])]
#[ORM\Entity(repositoryClass: AccomodationRepository::class)]
class Accomodation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    private ?int $area = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'accomodations')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'accomodation', targetEntity: Room::class, orphanRemoval:true,cascade:["remove"])]
    private Collection $room;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'accomodation', targetEntity: Booking::class, orphanRemoval:true, cascade:["remove"])]
    private Collection $bookings;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $longitude = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $latitude = null;

    public function __construct()
    {
        $this->room = new ArrayCollection();
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

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

    public function getArea(): ?int
    {
        return $this->area;
    }

    public function setArea(int $area): self
    {
        $this->area = $area;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    /**
     * @return Collection<int, Room>
     */
    public function getRoom(): Collection
    {
        return $this->room;
    }

    public function addRoom(Room $room): self
    {
        if (!$this->room->contains($room)) {
            $this->room->add($room);
            $room->setAccomodation($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): self
    {
        if ($this->room->removeElement($room)) {
            // set the owning side to null (unless already changed)
            if ($room->getAccomodation() === $this) {
                $room->setAccomodation(null);
            }
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPeopleMax()
    {   $maxPeople=0;
       foreach( $this->getRoom()as $room){
        foreach($room->getRoomBeds() as $roomBed){
            $bed=$roomBed->getBed();
            $quantity=$roomBed->getQuantity();
            $size=$bed->getSize();
            $bedQuantity=$size*$quantity;
            $maxPeople+=$bedQuantity;
           
        }
       }
       return $maxPeople;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setAccomodation($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getAccomodation() === $this) {
                $booking->setAccomodation(null);
            }
        }

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }
}
