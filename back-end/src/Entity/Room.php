<?php
declare(strict_types=1);

namespace App\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use JsonSerializable;

/**
 * @ORM\Entity
 * @ORM\Table(name="room")
 * @ORM\HasLifecycleCallbacks()
 */
class Room implements JsonSerializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\Column(type="integer") */
    private $pricePerNight;

    /** @ORM\Column(type="integer") */
    private $squareMeters;

    /** @ORM\Column(type="string", length=100) */
    private $floor;

    /** @ORM\Column(type="text") */
    private $description;

    /** @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="rooms") */
    private $owner;

    /** @ORM\Column(type="string", length=100, columnDefinition="ENUM('house', 'appartment', 'maisonette', 'guestRoom', 'hotel', 'chalet')") */
    private $roomType;

    /** @ORM\Column(type="integer") */
    private $totalOccupancy;

    /** @ORM\Column(type="integer") */
    private $totalBathrooms;

    /** @ORM\Column(type="integer") */
    private $totalBedrooms;

    /** @ORM\Column(type="integer") */
    private $totalBeds;

    /** @ORM\Column(type="boolean") */
    private $hasHeating;

    /** @ORM\Column(type="boolean") */
    private $hasAirConditioning;

    /** @ORM\Column(type="boolean") */
    private $hasKitchen;

    /** @ORM\Column(type="boolean") */
    private $hasLivingRoom;

    /** @ORM\Column(type="boolean") */
    private $hasTV;

    /** @ORM\Column(type="boolean") */
    private $hasWifi;

    /** @ORM\Column(type="boolean") */
    private $hasParking;

    /** @ORM\Column(type="boolean") */
    private $hasElevator;

    /** @ORM\Column(type="boolean") */
    private $isSmokingInsideAllowed;

    /** @ORM\Column(type="boolean") */
    private $arePetsAllowed;

    /** @ORM\Column(type="boolean") */
    private $arePartiesAllowed;

    /** @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="room")  */
    private $reservations;

    /** @ORM\Column(type="datetime") */
    private $createdAt;

    /** @ORM\Column(type="datetime") */
    private $updatedAt;

//    /** @ORM\Column(type="datetime") */
//    private $publishedAt;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    /** @return mixed */
    public function getRoomType()
    {
        return $this->roomType;
    }

    /** @param mixed $roomType */
    public function setRoomType($roomType): void
    {
        $this->roomType = $roomType;
    }

    /** @return mixed */
    public function getTotalOccupancy()
    {
        return $this->totalOccupancy;
    }

    /** @param mixed $totalOccupancy */
    public function setTotalOccupancy($totalOccupancy): void
    {
        $this->totalOccupancy = $totalOccupancy;
    }

    /** @return mixed */
    public function getTotalBathrooms()
    {
        return $this->totalBathrooms;
    }

    /** @param mixed $totalBathrooms */
    public function setTotalBathrooms($totalBathrooms): void
    {
        $this->totalBathrooms = $totalBathrooms;
    }

    /** @return mixed */
    public function getTotalBedrooms()
    {
        return $this->totalBedrooms;
    }

    /** @param mixed $totalBedrooms */
    public function setTotalBedrooms($totalBedrooms): void
    {
        $this->totalBedrooms = $totalBedrooms;
    }

    /** @return mixed */
    public function getTotalBeds()
    {
        return $this->totalBeds;
    }

    /** @param mixed $totalBeds */
    public function setTotalBeds($totalBeds): void
    {
        $this->totalBeds = $totalBeds;
    }

    /** @return mixed */
    public function getHasHeating()
    {
        return $this->hasHeating;
    }

    /** @param mixed $hasHeating */
    public function setHasHeating($hasHeating): void
    {
        $this->hasHeating = $hasHeating;
    }

    /** @return mixed */
    public function getHasAirConditioning()
    {
        return $this->hasAirConditioning;
    }

    /** @param mixed $hasAirConditioning */
    public function setHasAirConditioning($hasAirConditioning): void
    {
        $this->hasAirConditioning = $hasAirConditioning;
    }

    /** @return mixed */
    public function getHasKitchen()
    {
        return $this->hasKitchen;
    }

    /** @param mixed $hasKitchen */
    public function setHasKitchen($hasKitchen): void
    {
        $this->hasKitchen = $hasKitchen;
    }

    /** @return mixed */
    public function getHasLivingRoom()
    {
        return $this->hasLivingRoom;
    }

    /** @param mixed $hasLivingRoom */
    public function setHasLivingRoom($hasLivingRoom): void
    {
        $this->hasLivingRoom = $hasLivingRoom;
    }

    /** @return mixed */
    public function getHasTV()
    {
        return $this->hasTV;
    }

    /** @param mixed $hasTV */
    public function setHasTV($hasTV): void
    {
        $this->hasTV = $hasTV;
    }

    /** @return mixed */
    public function getHasWifi()
    {
        return $this->hasWifi;
    }

    /**
     * @param mixed $hasWifi
     */
    public function setHasWifi($hasWifi): void
    {
        $this->hasWifi = $hasWifi;
    }

    /**
     * @return mixed
     */
    public function getHasParking()
    {
        return $this->hasParking;
    }

    /** @param mixed $hasParking */
    public function setHasParking($hasParking): void
    {
        $this->hasParking = $hasParking;
    }

    /** @return mixed */
    public function getHasElevator()
    {
        return $this->hasElevator;
    }

    /** @param mixed $hasElevator */
    public function setHasElevator($hasElevator): void
    {
        $this->hasElevator = $hasElevator;
    }

    /**
     * @return mixed
     */
    public function getIsSmokingInsideAllowed()
    {
        return $this->isSmokingInsideAllowed;
    }

    /**
     * @param mixed $isSmokingInsideAllowed
     */
    public function setIsSmokingInsideAllowed($isSmokingInsideAllowed): void
    {
        $this->isSmokingInsideAllowed = $isSmokingInsideAllowed;
    }

    /** @return mixed */
    public function getArePetsAllowed()
    {
        return $this->arePetsAllowed;
    }

    /** @param mixed $arePetsAllowed */
    public function setArePetsAllowed($arePetsAllowed): self
    {
        $this->arePetsAllowed = $arePetsAllowed;
        return $this;
    }

    /** @return mixed */
    public function getArePartiesAllowed()
    {
        return $this->arePartiesAllowed;
    }

    /** @param mixed $arePartiesAllowed */
    public function setArePartiesAllowed($arePartiesAllowed): self
    {
        $this->arePartiesAllowed = $arePartiesAllowed;
        return $this;
    }

    /** @return mixed */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }


    /** @param mixed $createdAt */
    public function setCreatedAt(DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /** @return mixed */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /** @param mixed $updatedAt */
    public function setUpdatedAt(DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

//    /** @return mixed */
//    public function getPublishedAt()
//    {
//        return $this->publishedAt;
//    }
//
//    /** @param mixed $publishedAt */
//    public function setPublishedAt($publishedAt): self
//    {
//        $this->publishedAt = $publishedAt;
//        return $this;
//    }

    /** @return mixed */
    public function getId()
    {
        return $this->id;
    }

    /** @param mixed $id */
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    /** @return mixed */
    public function getDescription()
    {
        return $this->description;
    }

    /** @param mixed $description */
    public function setDescription($description): self
    {
        $this->description = $description;
        return $this;
    }

    /** @return mixed */
    public function getPricePerNight()
    {
        return $this->pricePerNight;
    }

    /** @param mixed $pricePerNight */
    public function setPricePerNight($pricePerNight): self
    {
        $this->pricePerNight = $pricePerNight;
        return $this;
    }

    /** @return mixed */
    public function getSquareMeters()
    {
        return $this->squareMeters;
    }

    /** @param mixed $squareMeters */
    public function setSquareMeters($squareMeters): void
    {
        $this->squareMeters = $squareMeters;
    }

    /** @return mixed */
    public function getFloor()
    {
        return $this->floor;
    }

    /** @param mixed $floor */
    public function setFloor($floor): void
    {
        $this->floor = $floor;
    }

    /**
     * @throws Exception
     * @ORM\PrePersist()
     */
    public function beforeSave()
    {
        if (!$this->createdAt) {
            $this->createdAt = new DateTime(
                'now',
                new DateTimeZone('Europe/Athens')
            );
        }

        $this->updatedAt = new DateTime(
            'now',
            new DateTimeZone('Europe/Athens')
        );
    }

    public function jsonSerialize()
    {
        return [
            "id" => $this->getId(),
            "pricePerNight" => $this->getPricePerNight(),
            "squareMeters" => $this->getSquareMeters(),
            "floor" => $this->getFloor(),
            "description" => $this->getDescription(),
            "roomType" => $this->getRoomType(),
            "totalOccupancy" => $this->getTotalOccupancy(),
            "totalBathrooms" => $this->getTotalBathrooms(),
            "totalBedrooms" => $this->getTotalBedrooms(),
            "totalBeds" => $this->getTotalBeds(),
            "hasTV" => $this->getHasTV(),
            "hasKitchen" => $this->getHasKitchen(),
            "hasLivingRoom" => $this->getHasLivingRoom(),
            "hasAirConditioning" => $this->getHasAirConditioning(),
            "hasHeating" => $this->getHasHeating(),
            "hasWifi" => $this->getHasWifi(),
            "hasParking" => $this->getHasParking(),
            "hasElevator" => $this->getHasElevator(),
            "isSmokingInsideAllowed" => $this->getIsSmokingInsideAllowed(),
            "arePetsAllowed" => $this->getArePetsAllowed(),
            "arePartiesAllowed" => $this->getArePartiesAllowed(),
            "createdAt" => $this->getCreatedAt(),
            "lastUpdatedAt" => $this->getUpdatedAt(),
            "ownerId" => $this->getOwner()->getId(),
            "reservations" => $this->getReservations(),
        ];
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    public function addReservation(Reservation $reservation): self
    {
        if ( !$this->reservations->contains($reservation) ) {
            $this->reservations[] = $reservation;
            $reservation->setRoom($this);
        }

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }
}
