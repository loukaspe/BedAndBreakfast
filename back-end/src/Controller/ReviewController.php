<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Review;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @package App\Controller
 * @Route("/api", name="reviewApi")
 */
class ReviewController extends ApiController
{
    /**
     * @param ReviewRepository $reviewRepository
     * @return JsonResponse
     * @Route("/reviews", name="reviews", methods={"GET"})
     */
    public function getReviews(ReviewRepository $reviewRepository)
    {

        try{
            $data = $reviewRepository->findAll();
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
     * @param reviewRepository $reviewRepository
     * @return JsonResponse
     * @throws Exception
     * @Route("/reviews", name="reviewsAdd", methods={"POST"})
     */
    public function addReview(
        Request $request,
        EntityManagerInterface $entityManager,
        reviewRepository $reviewRepository
    ) {
        try{
            $request = $this->transformJsonBody($request);

            if (
                !$request
                || !$request->get('rating')
                || !$request->get('comment')
                || !$request->get('reservationId')
            ) {
                //TODO: Explicit Exception
                throw new Exception();
            }

            /** @var Reservation */
            $reservation = $this->getDoctrine()
                ->getRepository(Reservation::class)
                ->find($request->get('reservationId'));

            if( empty($reservation) ) {
                //TODO: Explicit Exception
                throw new Exception();
            }

            $review = new Review();
            $review->setRating($request->get('rating'));
            $review->setComment($request->get('comment'));
            $review->setReservation($reservation);
            $reservation->setReview($review);

            $entityManager->persist($review);
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->respondWithSuccess("Review added successfully");

        } catch(Exception $exception){
            return $this->setStatusCode(422)
                ->respondWithErrors("Data input is not valid.");
        }

    }


    /**
     * @param ReviewRepository $reviewRepository
     * @param $id
     * @return JsonResponse
     * @Route("/reviews/{id}", name="reviewsGet", methods={"GET"})
     */
    public function getReview(ReviewRepository $reviewRepository, int $id)
    {
        $review = $reviewRepository->find($id);

        if (!$review){
            return $this->setStatusCode(404)
                ->respondWithErrors("Review with id ${id} was not found.");
        }

        return $this->respondWithSuccess($review);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param reviewRepository $reviewRepository
     * @param $id
     * @return JsonResponse
     * @Route("/reviews/{id}", name="reviewsPut", methods={"PUT"})
     */
    public function updateReview(
        Request $request,
        EntityManagerInterface $entityManager,
        ReviewRepository $reviewRepository,
        int $id
    ) {
        try{
            $review = $reviewRepository->find($id);

            if (!$review){
                return $this->setStatusCode(404)
                    ->respondWithErrors("Review with id ${id} was not found.");
            }

            $request = $this->transformJsonBody($request);

            if (
                !$request
                || !$request->get('rating')
                || !$request->get('comment')
            ) {
                //TODO: Explicit Exception
                throw new Exception();
            }

            $review->setRating($request->get('rating'));
            $review->setComment($request->get('comment'));
            $entityManager->flush();

            return $this->respondWithSuccess(
                "Review with id ${id} was updated successfully."
            );

        } catch(Exception $exception){
            return $this->setStatusCode(422)
                ->respondWithErrors("Data input was not valid.");
        }
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param reviewRepository $reviewRepository
     * @param $id
     * @return JsonResponse
     * @Route("/reviews/{id}", name="reviewsDelete", methods={"DELETE"})
     */
    public function deleteReview(
        EntityManagerInterface $entityManager,
        ReviewRepository $reviewRepository,
        int $id
    ) {
        $review = $reviewRepository->find($id);

        if (!$review){
            return $this->setStatusCode(404)
                ->respondWithErrors("Review with id ${id} was not found.");
        }

        $entityManager->remove($review);
        $entityManager->flush();

        return $this->respondWithSuccess("Review with id ${id} was deleted successfully");
    }
}