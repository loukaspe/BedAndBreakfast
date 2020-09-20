<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @package App\Controller
 * @Route("/api", name="userApi")
 */
final class UserController extends ApiController
{
    /**
     * @param UserRepository $userRepository
     * @return JsonResponse
     * @Route("/users", name="users", methods={"GET"})
     */
    public function getUsers(UserRepository $userRepository){

        try{
            $data = $userRepository->findAll();
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
     * @param userRepository $userRepository
     * @param $id
     * @return JsonResponse
     * @Route("/users/{id}", name="usersPut", methods={"PUT"})
     */
    public function updateUser(
        Request $request,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        UserPasswordEncoderInterface $encoder,
        int $id
    ) {
        try{
            $user = $userRepository->find($id);

            if (!$user){
                return $this->setStatusCode(404)
                    ->respondWithErrors("User with id ${id} was not found.");
            }

            $request = $this->transformJsonBody($request);

            //TODO: Maybe enable update with only one field
            if (
                !$request
                || !$request->get('password')
                || !$request->get('email')
                || !$request->get('firstName')
                || !$request->get('lastName')
                || !$request->get('role')
            ) {
                //TODO: Explicit Exception
                throw new Exception();
            }

            $user->setEmail($request->get('email'));
            $user->setFirstName($request->get('firstName'));
            $user->setLastName($request->get('lastName'));
            $user->setPassword(
                $encoder->encodePassword(
                    $user,
                    $request->get('password')
                )
            );
            $user->setRole($request->get('role'));

            return $this->respondWithSuccess(
                "User with id ${id} was updated successfully."
            );

        } catch(Exception $exception){
            return $this->setStatusCode(422)
                ->respondWithErrors("Data input was not valid.");
        }
    }

    /**
     * @param EntityManagerInterface $entityManager
     * @param UserRepository $userRepository
     * @param $id
     * @return JsonResponse
     * @Route("/users/{id}", name="usersDelete", methods={"DELETE"})
     */
    public function deleteUser(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        int $id
    ) {
        $user = $userRepository->find($id);

        if (!$user){
            return $this->setStatusCode(404)
                ->respondWithErrors("User with id ${id} was not found.");
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->respondWithSuccess("User with id ${id} was deleted successfully");
    }


//    /**
//     * @param UserRepository $userRepository
//     * @param $id
//     * @return JsonResponse
//     * @Route("/users/{id}", name="usersGet", methods={"GET"})
//     */
//    public function getUser(UserRepository $userRepository, int $id)
//    {
//        $user = $userRepository->find($id);
//
//        if (!$user){
//            return $this->setStatusCode(404)
//                ->respondWithErrors("User with id ${id} was not found.");
//        }
//
//        return $this->respondWithSuccess($user);
//    }
}
