<?php
declare(strict_types=1);

namespace App\Service\Room;

use App\Entity\Reservation;
use App\Entity\Room;
use DateTime;

final class AvailabilityValidator
{
    public function isRoomAvailable(
        Room $room,
        DateTime $startDate,
        DateTime $endDate
    ): bool {
        /** @var Reservation $reservation */
        foreach ($room->getReservations() as $reservation) {
            $reservationStartDate = $reservation->getStartDate();
            $reservationEndDate = $reservation->getEndDate();

            if(
                $startDate <= $reservationStartDate
                && $endDate >= $reservationEndDate
            ) {
                return false;
            }

            if(
                $startDate >= $reservationStartDate
                && $endDate <= $reservationEndDate
            ) {
                return false;
            }

            if(
                $startDate <= $reservationEndDate
                && $endDate >= $reservationEndDate
            ) {
                return false;
            }
        }

        return true;
    }
}
