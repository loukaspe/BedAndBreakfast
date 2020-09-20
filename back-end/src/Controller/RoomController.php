<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Room;
use App\Entity\User;
use App\Repository\RoomRepository;
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
                || !$request->get('longitude')
                || !$request->get('latitude')
                || !$request->get('squareMeters')
                || !$request->get('floor')
                || !$request->get('description')
                || !$request->get('roomType')
                || !$request->get('totalOccupancy')
                || !$request->get('totalBathrooms')
                || !$request->get('totalBedrooms')
                || !$request->get('totalBeds')
                || !$request->get('hasHeating')
                || !$request->get('hasAirConditioning')
                || !$request->get('hasKitchen')
                || !$request->get('hasLivingRoom')
                || !$request->get('hasTV')
                || !$request->get('hasWifi')
                || !$request->get('hasParking')
                || !$request->get('hasElevator')
                || !$request->get('isSmokingInsideAllowed')
                || !$request->get('arePetsAllowed')
                || !$request->get('arePartiesAllowed')
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
            $room->setLongitude($request->get('longitude'));
            $room->setLatitude($request->get('latitude'));
            $room->setSquareMeters($request->get('squareMeters'));
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
                || !$request->get('longitude')
                || !$request->get('latitude')
                || !$request->get('squareMeters')
                || !$request->get('floor')
                || !$request->get('description')
                || !$request->get('roomType')
                || !$request->get('totalOccupancy')
                || !$request->get('totalBathrooms')
                || !$request->get('totalBedrooms')
                || !$request->get('totalBeds')
                || !$request->get('hasHeating')
                || !$request->get('hasAirConditioning')
                || !$request->get('hasKitchen')
                || !$request->get('hasLivingRoom')
                || !$request->get('hasTV')
                || !$request->get('hasWifi')
                || !$request->get('hasParking')
                || !$request->get('hasElevator')
                || !$request->get('isSmokingInsideAllowed')
                || !$request->get('arePetsAllowed')
                || !$request->get('arePartiesAllowed')
            ) {
                //TODO: Explicit Exception
                throw new Exception();
            }

            $room->setPricePerNight($request->get('pricePerNight'));
            $room->setLongitude($request->get('longitude'));
            $room->setLatitude($request->get('latitude'));
            $room->setSquareMeters($request->get('squareMeters'));
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