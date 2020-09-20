<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Room;
use App\Entity\User;
use App\Repository\ReservationRepository;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller
 * @Route("/api", name="reservationApi")
 */
class ReservationController extends ApiController
{
    const ATHENS_TIMEZONE = 'Europe/Athens';

    /**
     * @param ReservationRepository $reservationRepository
     * @return JsonResponse
     * @Route("/reservations", name="reservations", methods={"GET"})
     */
    public function getReservations(ReservationRepository $reservationRepository)
    {

        try{
            $data = $reservationRepository->findAll();
        } catch(Exception $exception) {
            return $this
                ->setStatusCode(500)
                ->respondWithErrors("Technical Issue.".$exception->getMessage());
        }

        return $this->respondWithSuccess($data);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ReservationRepository $reservationRepository
     * @return JsonResponse
     * @throws Exception
     * @Route("/reservations", name="reservationsAdd", methods={"POST"})
     */
    public function addReservation(
        Request $request,
        EntityManagerInterface $entityManager,
        ReservationRepository $reservationRepository
    ) {
        try{
            $request = $this->transformJsonBody($request);

            if (
                !$request
                || !$request->get('startDate')
                || !$request->get('endDate')
                || !$request->get('price')
                || !$request->get('total')
                || !$request->get('roomId')
                || !$request->get('userId')

            ) {
                //TODO: Explicit Exception
                throw new Exception();
            }

            $startDate = new DateTime(
                $request->get('startDate'),
                new DateTimeZone(self::ATHENS_TIMEZONE)
            );

            $endDate = new DateTime(
                $request->get('endDate'),
                new DateTimeZone(self::ATHENS_TIMEZONE)
            );

            /** @var User $user */
            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->find($request->get('userId'));

            /** @var Room $room */
            $room = $this->getDoctrine()
                ->getRepository(Room::class)
                ->find($request->get('roomId'));

            if( empty($user) || empty($room) ) {
                //TODO: Explicit Exception
                throw new Exception();
            }

            $reservation = new Reservation();
            $reservation->setStartDate($startDate);
            $reservation->setEndDate($endDate);
            $reservation->setPrice($request->get('price'));
            $reservation->setTotal($request->get('total'));
//            $reservation->setRoom($room);
//            $reservation->setUser($user);

            $user->addReservation($reservation);
            $room->addReservation($reservation);

            $entityManager->persist($reservation);
            $entityManager->persist($user);
            $entityManager->persist($room);
            $entityManager->flush();

            return $this->respondWithSuccess("Reservation added successfully");

        } catch(Exception $exception){
            return $this->setStatusCode(422)
                ->respondWithErrors("Data input is not valid.".$exception->getMessage());
        }

    }


    /**
     * @param ReservationRepository $reservationRepository
     * @param $id
     * @return JsonResponse
     * @Route("/reservations/{id}", name="reservationsGet", methods={"GET"})
     */
    public function getReservation(ReservationRepository $reservationRepository, int $id)
    {
        $reservation = $reservationRepository->find($id);

        if (!$reservation){
            return $this->setStatusCode(404)
                ->respondWithErrors("Reservation with id ${id} was not found.");
        }

        return $this->respondWithSuccess($reservation);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param ReservationRepository $reservationRepository
     * @param $id
     * @return JsonResponse
     * @Route("/reservations/{id}", name="reservationsPut", methods={"PUT"})
     */
    public function updateReservation(
        Request $request,
        EntityManagerInterface $entityManager,
        ReservationRepository $reservationRepository,
        int $id
    ) {
        try{
            /** @var Reservation $reservation */
            $reservation = $reservationRepository->find($id);

            if (!$reservation){
                return $this->setStatusCode(404)
                    ->respondWithErrors("Reservation with id ${id} was not found.");
            }

            $request = $this->transformJsonBody($request);

            if (
                !$request
                || !$request->get('startDate')
                || !$request->get('endDate')
                || !$request->get('price')
                || !$request->get('total')
                || !$request->get('roomId')
                || !$request->get('userId')

            ) {
                //TODO: Explicit Exception
                throw new Exception();
            }

            $startDate = new DateTime(
                $request->get('startDate'),
                new DateTimeZone(self::ATHENS_TIMEZONE)
            );

            $endDate = new DateTime(
                $request->get('endDate'),
                new DateTimeZone(self::ATHENS_TIMEZONE)
            );

            /** @var User $user */
            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->find($request->get('userId'));

            /** @var Room $room */
            $room = $this->getDoctrine()
                ->getRepository(Room::class)
                ->find($request->get('roomId'));

            if( empty($user) || empty($room) ) {
                //TODO: Explicit Exception
                throw new Exception();
            }

            $reservation->setStartDate($startDate);
            $reservation->setEndDate($endDate);
            $reservation->setPrice($request->get('price'));
            $reservation->setTotal($request->get('total'));
            $entityManager->flush();

            return $this->respondWithSuccess(
                "Reservation with id ${id} was updated successfully."
            );

        } catch(Exception $exception){
            return $this->setStatusCode(422)
                ->respondWithErrors("Data input was not valid.".$exception->getMessage());
        }
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param ReservationRepository $reservationRepository
     * @param $id
     * @return JsonResponse
     * @Route("/reservations/{id}", name="reservationsDelete", methods={"DELETE"})
     */
    public function deleteReservation(
        EntityManagerInterface $entityManager,
        ReservationRepository $reservationRepository,
        int $id
    ) {
        $reservation = $reservationRepository->find($id);

        if (!$reservation){
            return $this->setStatusCode(404)
                ->respondWithErrors("Reservation with id ${id} was not found.");
        }

        $entityManager->remove($reservation);
        $entityManager->flush();

        return $this->respondWithSuccess("Reservation with id ${id} was deleted successfully");
    }
}