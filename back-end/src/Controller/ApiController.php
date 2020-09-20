<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{

    /** @var integer HTTP status code - 200 (OK) by default */
    protected $statusCode = 200;

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    protected function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function response(array $data, array $headers = []): JsonResponse
    {
        return new JsonResponse($data, $this->getStatusCode(), $headers);
    }

    /**
     * Sets an error message and returns a JSON response
     *
     * @param string $errors
     * @param $headers
     * @return JsonResponse
     */
    public function respondWithErrors(
        string $errors,
        array $headers = []
    ): JsonResponse {
        $data = [
            'status' => $this->getStatusCode(),
            'errors' => $errors,
        ];

        return new JsonResponse($data, $this->getStatusCode(), $headers);
    }

    public function respondWithSuccess(
        $success,
        array $headers = []
    ): JsonResponse {
        $data = [
            'status' => $this->getStatusCode(),
            'success' => $success,
        ];

        return new JsonResponse($data, $this->getStatusCode(), $headers);
    }

    public function respondUnauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return $this
            ->setStatusCode(401)
            ->respondWithErrors($message);
    }

    /**
     * Returns a 422 Unprocessable Entity
     *
     * @param string $message
     *
     * @return JsonResponse
     */
    public function respondValidationError(
        string $message = 'Validation errors'
    ): JsonResponse {
        return $this
            ->setStatusCode(422)
            ->respondWithErrors($message);
    }

    public function respondNotFound(
        string $message = 'Not found!'
    ): JsonResponse {
        return $this
            ->setStatusCode(404)
            ->respondWithErrors($message);
    }

    public function respondCreated(array $data = []): JsonResponse
    {
        return $this
            ->setStatusCode(201)
            ->response($data);
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
