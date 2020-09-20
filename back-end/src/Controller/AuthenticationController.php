<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class AuthenticationController extends ApiController
{
    public function register(
        Request $request,
        UserPasswordEncoderInterface $encoder
    ) {
        //TODO: Adjust to our User's fields
        $doctrineManager = $this->getDoctrine()->getManager();
        $request = $this->transformJsonBody($request);

        $username = $request->get('username');
        $password = $request->get('password');
        $email = $request->get('email');
        $firstName = $request->get('firstName');
        $lastName = $request->get('lastName');
        $role = $request->get('role');
        $phone = $request->get('phone');

        if (
            empty($username)
            || empty($password)
            || empty($email)
            || empty($firstName)
            || empty($lastName)
            || empty($role)
            || empty($phone)
        ){
            return $this->respondValidationError(
                "Invalid Registration Input. Please fill all fields."
            );
        }

        $user = new User($username);
        $user->setPassword($encoder->encodePassword($user, $password));
        $user->setEmail($email);
        $user->setUsername($username);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setRole($role);
        $user->setPhone($phone);

        $doctrineManager->persist($user);
        $doctrineManager->flush();

        return $this->respondWithSuccess(
            sprintf('User %s successfully created', $user->getUsername())
        );
    }

    public function getTokenUser(
        UserInterface $user,
        JWTTokenManagerInterface $jwtManager
    ): JsonResponse {
        return new JsonResponse(['token' => $jwtManager->create($user)]);
    }

}
