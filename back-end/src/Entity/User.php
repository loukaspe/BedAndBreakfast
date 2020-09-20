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
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface, JsonSerializable
{

    const USER_ROLES = [
      'admin' => 'admin',
      'host' => 'host',
      'guest' => 'guest',
      'both' => 'both',
    ];

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\Column(type="string", length=100, unique=true) */
    private $username;

    /** @ORM\Column(type="string", length=255) */
    private $password;

    /** @ORM\Column(type="string", length=100) */
    private $firstName;

    /** @ORM\Column(type="string", length=100) */
    private $lastName;

    /** @ORM\Column(type="string", length=100) */
    private $email;

    /** @ORM\Column(type="string", length=13) */
    private $phone;
    //TODO: Do we need an anonymous user role? Do we need both user role ?

    /** @ORM\Column(type="string", length=100, columnDefinition="ENUM('admin', 'host', 'guest', 'both')") */
    private $role;

//    /** @ORM\Column(type="string") */
//    private $photo;

    /** @ORM\OneToMany(targetEntity="App\Entity\Room", mappedBy="owner")  */
    private $rooms;

    /** @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="user")  */
    private $reservations;

    /** @ORM\Column(type="datetime") */
    private $createdAt;

    /** @ORM\Column(type="datetime") */
    private $updatedAt;

    public function __construct(string $username)
    {
        $this->username = $username;
        $this->rooms = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

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

    /** @return string */
    public function getUsername(): string
    {
        return $this->username;
    }

    /** @param string $username */
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /** @return mixed */
    public function getPassword()
    {
        return $this->password;
    }

    /** @param mixed $password */
    public function setPassword($password): self
    {
        $this->password = $password;
        return $this;
    }

    /** @return mixed */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /** @param mixed $firstName */
    public function setFirstName($firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    /** @return mixed */
    public function getLastName()
    {
        return $this->lastName;
    }

    /** @param mixed $lastName */
    public function setLastName($lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    /** @return mixed */
    public function getEmail()
    {
        return $this->email;
    }

    /** @param mixed $email */
    public function setEmail($email): self
    {
        $this->email = $email;
        return $this;
    }

    /** @return mixed */
    public function getPhone()
    {
        return $this->phone;
    }

    /** @param mixed $phone */
    public function setPhone($phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    /** @return mixed */
    public function getRole()
    {
        return $this->role;
    }

    /** @param mixed $role */
    public function setRole($role): self
    {
        $this->role = $role;
        return $this;
    }

//    /** @return mixed */
//    public function getPhoto()
//    {
//        return $this->photo;
//    }
//
//    /** @param mixed $photo */
//    public function setPhoto($photo): self
//    {
//        $this->photo = $photo;
//        return $this;
//    }

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

    //TODO: Do we need it ?
    /**
     * @return string|null
     */
    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
        // No action
    }

    public function getRoles()
    {
        return self::USER_ROLES;
    }

    public function jsonSerialize()
    {
        return [
            "id" => $this->getId(),
            "username" => $this->getUsername(),
            "firstName" => $this->getFirstName(),
            "lastName" => $this->getLastName(),
            "email" => $this->getEmail(),
            "phone" => $this->getPhone(),
            "role" => $this->getRole(),
//            "photo" => $this->getPhoto(),
            "rooms" => $this->printRoomsAsJson(),
            "reservations" => $this->printReservationsAsJson(),
            "createdAt" => $this->getCreatedAt(),
            "updatedAt" => $this->getUpdatedAt(),
        ];
    }

    public function addRoom(Room $room): self
    {
        if ( !$this->rooms->contains($room) ) {
            $this->rooms[] = $room;
            $room->setOwner($this);
        }

        return $this;
    }

    public function addReservation(Reservation $reservation): self
    {
        if ( !$this->reservations->contains($reservation) ) {
            $this->reservations[] = $reservation;
            $reservation->setUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Room[]
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function printRoomsAsJson(): array
    {
        $roomsInJson = array();

        /** @var Room $room */
        foreach ($this->rooms as $room) {
            $roomsInJson[] = $room->getId();
        }

        return $roomsInJson ? $roomsInJson : [];
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function printReservationsAsJson(): array
    {
        $reservationInJson = array();

        /** @var Reservation $reservation */
        foreach ($this->reservations as $reservation) {
            $reservationInJson[] = $reservation->getId();
        }

        return $reservationInJson ? $reservationInJson : [];
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
}
