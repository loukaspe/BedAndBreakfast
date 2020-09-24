<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Room;
use App\Entity\User;
use App\Repository\RoomRepository;
use App\Service\Room\AvailabilityValidator;
use DateTime;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller
 * @Route("/api", name="roomApi")
 */
class RoomController extends ApiController
{
    const ATHENS_TIMEZONE = 'Europe/Athens';
    /**
     * @param RoomRepository $roomRepository
     * @return JsonResponse
     * @Route("/rooms", name="rooms", methods={"GET"})
     */
    public function getRooms(RoomRepository $roomRepository)
    {

        try{
            $data = $roomRepository->findAll();
        } catch(Exception $exception) {
            return $this
                ->setStatusCode(500)
                ->respondWithErrors("Technical Issue.");
        }

        return $this->respondWithSuccess($data);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param roomRepository $roomRepository
     * @return JsonResponse
     * @throws Exception
     * @Route("/rooms", name="roomsAdd", methods={"POST"})
     */
    public function addRoom(
        Request $request,
        EntityManagerInterface $entityManager,
        roomRepository $roomRepository
    ) {

        try{
            $request = $this->transformJsonBody($request);

            if (
                !$request
                || !$request->get('pricePerNight')
                || !$request->get('squareMeters')
                || !$request->get('floor')
                || !$request->get('locality')
                || !$request->get('area')
                || !$request->get('description')
                || !$request->get('roomType')
                || !$request->get('totalOccupancy')
                || !$request->get('totalBathrooms')
                || !$request->get('totalBedrooms')
                || !$request->get('totalBeds')
                || $request->get('hasHeating') === null
                || $request->get('hasAirConditioning') === null
                || $request->get('hasKitchen') === null
                || $request->get('hasLivingRoom') === null
                || $request->get('hasTV') === null
                || $request->get('hasWifi') === null
                || $request->get('hasParking') === null
                || $request->get('hasElevator') === null
                || $request->get('isSmokingInsideAllowed') === null
                || $request->get('arePetsAllowed') === null
                || $request->get('arePartiesAllowed') === null
                || !$request->get('userId')
            ) {
                //TODO: Explicit Exception
                throw new Exception();
            }

            /** @var User $user */
            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->find($request->get('userId'));

            if( empty($user) || !isset($user)) {
                //TODO: Explicit Exception
                throw new Exception();
            }

            $room = new Room();
            $room->setPricePerNight($request->get('pricePerNight'));
            $room->setSquareMeters($request->get('squareMeters'));
            $room->setLocality($request->get('locality'));
            $room->setArea($request->get('area'));
            $room->setFloor($request->get('floor'));
            $room->setDescription($request->get('description'));
            $room->setRoomType($request->get('roomType'));
            $room->setTotalOccupancy($request->get('totalOccupancy'));
            $room->setTotalBathrooms($request->get('totalBathrooms'));
            $room->setTotalBedrooms($request->get('totalBedrooms'));
            $room->setTotalBeds($request->get('totalBeds'));
            $room->setHasHeating($request->get('hasHeating'));
            $room->setHasAirConditioning($request->get('hasAirConditioning'));
            $room->setHasKitchen($request->get('hasKitchen'));
            $room->setHasLivingRoom($request->get('hasLivingRoom'));
            $room->setHasTV($request->get('hasTV'));
            $room->setHasWifi($request->get('hasWifi'));
            $room->setHasParking($request->get('hasParking'));
            $room->setHasElevator($request->get('hasElevator'));
            $room->setIsSmokingInsideAllowed($request->get('isSmokingInsideAllowed'));
            $room->setArePetsAllowed($request->get('arePetsAllowed'));
            $room->setArePartiesAllowed($request->get('arePartiesAllowed'));
//            $room->setOwner($user);

            $user->addRoom($room);

            $entityManager->persist($user);
            $entityManager->persist($room);
            $entityManager->flush();

            return $this->respondWithSuccess("Room added successfully");

        } catch(Exception $exception){
            return $this->setStatusCode(422)
                ->respondWithErrors("Data input is not valid.". $exception->getMessage());
        }
    }

    /**
     * @param RoomRepository $roomRepository
     * @param $id
     * @return JsonResponse
     * @Route("/rooms/{id}", name="roomsGet", methods={"GET"})
     */
    public function getRoom(RoomRepository $roomRepository, int $id)
    {
        $room = $roomRepository->find($id);

        if (!$room){
            return $this->setStatusCode(404)
                ->respondWithErrors("Room with id ${id} was not found.");
        }

        return $this->respondWithSuccess($room);
    }

    /**
     * @param Request $request
     * @param RoomRepository $roomRepository
     * @param AvailabilityValidator $availabilityValidator
     * @return JsonResponse
     * @throws Exception
     * @Route("/searchRooms", name="roomsGetByArea", methods={"POST"})
     */
    public function searchForRoom(
        Request $request,
        RoomRepository $roomRepository,
        AvailabilityValidator $availabilityValidator
    ) {
        $request = $this->transformJsonBody($request);

        if (
            !$request
            || !$request->get('startDate')
            || !$request->get('endDate')
            || !$request->get('locality')
            || !$request->get('area')
        ) {
            return $this
                ->setStatusCode(422)
                ->respondWithErrors(
                    "Invalid Data Input."
                );
        }

        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');
        $locality = $request->get('locality');
        $area = $request->get('area');

        /** @var array $rooms */
        $rooms = $roomRepository->findByLocalityAndArea($locality, $area);

        try {
            $startDateObject = new DateTime(
                $startDate,
                new DateTimeZone(self::ATHENS_TIMEZONE)
            );

            $endDateObject = new DateTime(
                $endDate,
                new DateTimeZone(self::ATHENS_TIMEZONE)
            );
        } catch (Exception $exception) {
            return $this->setStatusCode(500)
                ->respondWithErrors(
                    "Technical Issue."
                );
        }

        if (!$rooms){
            return $this->setStatusCode(404)
                ->respondWithErrors(
                    "No Room was found in area ${locality}, ${area}."
                );
        }

        foreach ($rooms as $room) {
            if(
                ! $availabilityValidator->isRoomAvailable(
                    $room,
                    $startDateObject,
                    $endDateObject
                )
            ) {
                unset($room);
            }
        }

        return $this->respondWithSuccess($rooms);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param roomRepository $roomRepository
     * @param $id
     * @return JsonResponse
     * @Route("/rooms/{id}", name="roomsPut", methods={"PUT"})
     */
    public function updateRoom(
        Request $request,
        EntityManagerInterface $entityManager,
        RoomRepository $roomRepository,
        int $id
    ) {
        try{
            $room = $roomRepository->find($id);

            if (!$room){
                return $this->setStatusCode(404)
                    ->respondWithErrors("Room with id ${id} was not found.");
            }

            $request = $this->transformJsonBody($request);

            if (
                !$request
                || !$request->get('pricePerNight')
                || !$request->get('squareMeters')
                || !$request->get('floor')
                || !$request->get('locality')
                || !$request->get('area')
                || !$request->get('description')
                || !$request->get('roomType')
                || !$request->get('totalOccupancy')
                || !$request->get('totalBathrooms')
                || !$request->get('totalBedrooms')
                || !$request->get('totalBeds')
                || $request->get('hasHeating') === null
                || $request->get('hasAirConditioning') === null
                || $request->get('hasKitchen') === null
                || $request->get('hasLivingRoom') === null
                || $request->get('hasTV') === null
                || $request->get('hasWifi') === null
                || $request->get('hasParking') === null
                || $request->get('hasElevator') === null
                || $request->get('isSmokingInsideAllowed') === null
                || $request->get('arePetsAllowed') === null
                || $request->get('arePartiesAllowed') === null
            ) {
                //TODO: Explicit Exception
                throw new Exception();
            }

            $room->setPricePerNight($request->get('pricePerNight'));
            $room->setSquareMeters($request->get('squareMeters'));
            $room->setFloor($request->get('floor'));
            $room->setLocality($request->get('locality'));
            $room->setArea($request->get('area'));
            $room->setDescription($request->get('description'));
            $room->setRoomType($request->get('roomType'));
            $room->setTotalOccupancy($request->get('totalOccupancy'));
            $room->setTotalBathrooms($request->get('totalBathrooms'));
            $room->setTotalBedrooms($request->get('totalBedrooms'));
            $room->setTotalBeds($request->get('totalBeds'));
            $room->setHasHeating($request->get('hasHeating'));
            $room->setHasAirConditioning($request->get('hasAirConditioning'));
            $room->setHasKitchen($request->get('hasKitchen'));
            $room->setHasLivingRoom($request->get('hasLivingRoom'));
            $room->setHasTV($request->get('hasTV'));
            $room->setHasWifi($request->get('hasWifi'));
            $room->setHasParking($request->get('hasParking'));
            $room->setHasElevator($request->get('hasElevator'));
            $room->setIsSmokingInsideAllowed($request->get('isSmokingInsideAllowed'));
            $room->setArePetsAllowed($request->get('arePetsAllowed'));
            $room->setArePartiesAllowed($request->get('arePartiesAllowed'));

            $entityManager->flush();

            return $this->respondWithSuccess(
                "Room with id ${id} was updated successfully."
            );

        } catch(Exception $exception){
            return $this->setStatusCode(422)
                ->respondWithErrors("Data input was not valid.");
        }
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param roomRepository $roomRepository
     * @param $id
     * @return JsonResponse
     * @Route("/rooms/{id}", name="roomsDelete", methods={"DELETE"})
     */
    public function deleteRoom(
        EntityManagerInterface $entityManager,
        RoomRepository $roomRepository,
        int $id
    ) {
        $room = $roomRepository->find($id);

        if (!$room){
            return $this->setStatusCode(404)
                ->respondWithErrors("Room with id ${id} was not found.");
        }

        $entityManager->remove($room);
        $entityManager->flush();

        return $this->respondWithSuccess("Room with id ${id} was deleted successfully");
    }
}