<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\room;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller
 * @Route("/api", name="roomApi")
 */
class RoomController extends AbstractController
{
    /**
     * @param RoomRepository $roomRepository
     * @return JsonResponse
     * @Route("/rooms", name="rooms", methods={"GET"})https://www.airbnb.gr/rooms/39057053?check_in=2020-09-19&check_out=2020-09-25&previous_page_section_name=1000&federated_search_id=a66f9069-d9cb-41d8-8a13-9989028d3db7
     */
    public function getRooms(RoomRepository $roomRepository){

        try{
            $data = $roomRepository->findAll();
        } catch(Exception $exception) {
            $data = [
                'status' => 500,
                'message' => "Tecnhical Issue.",
            ];

            return $this->response($data, 500);
        }

        return $this->response($data, 200);
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
                || !$request->get('heating')
                || !$request->get('description')
            ) {
                //TODO: Explicit Exception
                throw new Exception();
            }

            $room = new Room();
            $room->setPricePerNight($request->get('pricePerNight'));
            $room->setLongitude($request->get('longitude'));
            $room->setLatitude($request->get('latitude'));
            $room->setSquareMeters($request->get('squareMeters'));
            $room->setFloor($request->get('floor'));
            $room->setHeating($request->get('heating'));
            $room->setDescription($request->get('description'));
            $entityManager->persist($room);
            $entityManager->flush();

            $data = [
                'status' => 200,
                'success' => "Room added successfully",
            ];

            return $this->response($data, 200);

        } catch(Exception $exception){
            $data = [
                'status' => 422,
                'message' => "Data input is not valid.",
                'errorMessage' => $exception->getMessage()
            ];
            return $this->response($data, 422);
        }

    }


    /**
     * @param roomRepository $roomRepository
     * @param $id
     * @return JsonResponse
     * @Route("/rooms/{id}", name="roomsGet", methods={"GET"})
     */
    public function getRoom(roomRepository $roomRepository, int $id)
    {
        $room = $roomRepository->find($id);

        if (!$room){
            $data = [
                'status' => 404,
                'message' => "Room with id ${id} was not found.",
            ];

            return $this->response($data, 404);
        }

        $data = [
            'status' => 200,
            'room' => $room
        ];

        return $this->response($data, 200);
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
                $data = [
                    'status' => 404,
                    'message' => "Room with id ${id} was not found.",
                ];

                return $this->response($data, 404);
            }

            $request = $this->transformJsonBody($request);

            if (
                !$request
                || !$request->get('pricePerNight')
                || !$request->get('longitude')
                || !$request->get('latitude')
                || !$request->get('squareMeters')
                || !$request->get('floor')
                || !$request->get('heating')
                || !$request->get('description')
            ) {
                //TODO: Explicit Exception
                throw new Exception();
            }

            $room->setPricePerNight($request->get('pricePerNight'));
            $room->setLongitude($request->get('longitude'));
            $room->setLatitude($request->get('latitude'));
            $room->setSquareMeters($request->get('squareMeters'));
            $room->setFloor($request->get('floor'));
            $room->setHeating($request->get('heating'));
            $entityManager->flush();

            $data = [
                'status' => 200,
                'message' => "Room with id ${id} was updated successfully.",
            ];

            return $this->response($data, 200);

        } catch(Exception $exception){
            $data = [
                'status' => 422,
                'message' => "Data input was not valid.",
            ];

            return $this->response($data, 422);
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
            $data = [
                'status' => 404,
                'message' => "Room with id ${id} was not found.",
            ];

            return $this->response($data, 404);
        }

        $entityManager->remove($room);
        $entityManager->flush();

        $data = [
            'status' => 200,
            'message' => "Room with id ${id} was deleted successfully",
        ];

        return $this->response($data, 200);
    }

    /**
     * Returns a JSON response
     *
     * @param array $data
     * @param $status
     * @param array $headers
     * @return JsonResponse
     */
    public function response($data, $status = 200, $headers = [])
    {
        return new JsonResponse($data, $status, $headers);
    }

    protected function transformJsonBody(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }

}