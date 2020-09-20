<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

/**
 * @ORM\Entity
 * @ORM\Table(name="review")
 * @ORM\HasLifecycleCallbacks()
 */
class Review implements JsonSerializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\OneToOne(targetEntity="App\Entity\Reservation")  */
    private $reservation;

    /** @ORM\Column(type="integer") */
    private $rating;

    /** @ORM\Column(type="text") */
    private $comment;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }


    public function getReservation(): Reservation
    {
        return $this->reservation;
    }

    public function setReservation(Reservation $reservation): self
    {
        $this->reservation = $reservation;
        return $this;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;
        return $this;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            "id" => $this->getId(),
            "reservationId" => $this->getReservation()->getId(),
            "rating" => $this->getRating(),
            "comment" => $this->getComment(),
        ];
    }
}
