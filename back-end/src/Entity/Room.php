<?php
declare(strict_types=1);

namespace App\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use JsonSerializable;

/**
 * @ORM\Entity
 * @ORM\Table(name="room")
 * @ORM\HasLifecycleCallbacks()
 */
final class Room  implements JsonSerializable
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
    private $longitude;

    /** @ORM\Column(type="integer") */
    private $latitude;

    /** @ORM\Column(type="integer") */
    private $squareMeters;

    /** @ORM\Column(type="string", length=100) */
    private $floor;

    /** @ORM\Column(type="text") */
    private $description;


    /** @ORM\Column(
     *     type="string",
     *     length=100,
     *     columnDefinition="ENUM(
     *      'house',
     *      'appartment',
     *      'maisonette',
     *      'guestRoom',
     *      'hotel,
     *      'chalet'
     *     )"
     * )
     */
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

    /** @ORM\Column(type="integer") */
    private $ownerId;

    /** @ORM\Column(type="datetime") */
    private $createdAt;

    /** @ORM\Column(type="datetime") */
    private $updatedAt;

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
    public function setArePetsAllowed($arePetsAllowed): void
    {
        $this->arePetsAllowed = $arePetsAllowed;
    }

    /** @return mixed */
    public function getArePartiesAllowed()
    {
        return $this->arePartiesAllowed;
    }

    /** @param mixed $arePartiesAllowed */
    public function setArePartiesAllowed($arePartiesAllowed): void
    {
        $this->arePartiesAllowed = $arePartiesAllowed;
    }

    /** @return mixed */
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /** @param mixed $ownerId */
    public function setOwnerId($ownerId): void
    {
        $this->ownerId = $ownerId;
    }

    /** @return mixed */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    //TODO: Why return self ??
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

    /** @return mixed */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /** @param mixed $publishedAt */
    public function setPublishedAt($publishedAt): void
    {
        $this->publishedAt = $publishedAt;
    }

    /** @ORM\Column(type="datetime") */
    private $publishedAt;

    /** @return mixed */
    public function getId()
    {
        return $this->id;
    }

    /** @param mixed $id */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /** @return mixed */
    public function getDescription()
    {
        return $this->description;
    }

    /** @param mixed $description */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /** @return mixed */
    public function getPricePerNight()
    {
        return $this->pricePerNight;
    }

    /** @param mixed $pricePerNight */
    public function setPricePerNight($pricePerNight): void
    {
        $this->pricePerNight = $pricePerNight;
    }

    /** @return mixed */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /** @param mixed $longitude */
    public function setLongitude($longitude): void
    {
        $this->longitude = $longitude;
    }

    /** @return mixed */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /** @param mixed $latitude */
    public function setLatitude($latitude): void
    {
        $this->latitude = $latitude;
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
        $this->createdAt = new DateTime(
            'now',
            new DateTimeZone('Europe/Athens')
        );
    }

    public function jsonSerialize()
    {
        return [
            "id" => $this->getId(),
            "pricePerNight" => $this->getPricePerNight(),
            "longitude" => $this->getLongitude(),
            "latitude" => $this->getLatitude(),
            "squareMeters" => $this->getSquareMeters(),
            "floor" => $this->getFloor(),
            "description" => $this->getDescription(),
            'roomType' => $this->getRoomType(),
            'totalOccupancy' => $this->getTotalOccupancy(),
            'totalBathrooms' => $this->getTotalBathrooms(),
            'totalBedrooms' => $this->getTotalBedrooms(),
            'totalBeds' => $this->getTotalBeds(),
            'hasTV' => $this->getHasTV(),
            'hasKitchen' => $this->getHasKitchen(),
            'hasLivingRoom' => $this->getHasLivingRoom(),
            'hasAirConditioning' => $this->getHasAirConditioning(),
            'hasHeating' => $this->getHasHeating(),
            'hasWifi' => $this->getHasWifi(),
            'hasParking' => $this->getHasParking(),
            'hasElevator' => $this->getHasElevator(),
            'isSmokingInsideAllowed' => $this->getIsSmokingInsideAllowed(),
            'arePetsAllowed' => $this->getArePetsAllowed(),
            'arePartiesAllowed' => $this->getArePartiesAllowed(),
            'createdAt' => $this->getCreatedAt(),
            'lastUpdatedAt' => $this->getUpdatedAt(),
            'publishedAt' => $this->getPublishedAt(),
            'ownerId' => $this->getOwnerId()
        ];
    }
}