<?php
declare(strict_types=1);

namespace App\Entity;

use DateTime;
use DateTimeZone;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity
 * @ORM\Table(name="reservation")
 * @ORM\HasLifecycleCallbacks()
 */
class Reservation implements JsonSerializable
{
    const ATHENS_TIMEZONE = 'Europe/Athens';
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reservations") */
    private $user;

    /** @ORM\ManyToOne(targetEntity="App\Entity\Room", inversedBy="reservations") */
    private $room;

    /** @ORM\Column(type="datetime") */
    private $startDate;

    /** @ORM\Column(type="datetime") */
    private $endDate;

    /** @ORM\Column(type="integer") */
    private $price;

    /** @ORM\Column(type="integer") */
    private $total;

    /** @ORM\OneToOne(targetEntity="App\Entity\Review") Review */
    private $review;

    /** @ORM\Column(type="datetime") */
    private $createdAt;

    /** @ORM\Column(type="datetime") */
    private $updatedAt;

    public function jsonSerialize()
    {
        return [
            "id" => $this->getId(),
            "startDate" => $this->getStartDate(),
            "endDate" => $this->getEndDate(),
            "price" => $this->getPrice(),
            "total" => $this->getTotal(),
            "userId" => $this->getUser()->getId(),
            "roomId" => $this->getRoom()->getId(),
            "reviewId" => (isset($this->review))
                ? $this->review->getId()
                : "",
            "createdAt" => $this->getCreatedAt(),
            "updatedAt" => $this->getUpdatedAt(),
        ];
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getRoom(): Room
    {
        return $this->room;
    }

    public function setRoom(Room $room): self
    {
        $this->room = $room;
        return $this;
    }

    public function getReview(): Review
    {
        return $this->review;
    }

    public function setReview(Review $review): self
    {
        $this->review = $review;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }


    public function setStartDate(DateTime $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(DateTime $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getTotal(): int
    {
        return $this->total;
    }


    public function setTotal(int $total): self
    {
        $this->total = $total;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
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
                new DateTimeZone(self::ATHENS_TIMEZONE)
            );
        }

        $this->updatedAt = new DateTime(
            'now',
            new DateTimeZone(self::ATHENS_TIMEZONE)
        );
    }
}
