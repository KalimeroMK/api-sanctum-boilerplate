<?php

namespace Modules\Core\Traits;

use Exception;
use Illuminate\Http\JsonResponse;

trait ApiResponses
{
    /**
     * @var int
     */
    public int $responseCode = 200;

    /**
     * @var string
     */
    public string $message = 'OK';

    /**
     * @var string
     */
    public string $title = 'Success';

    /**
     * Sets the HTTP response code.
     *
     * @param  int  $code
     * @return $this
     */
    public function setCode(int $code = 200): static
    {
        $this->responseCode = $code;
        return $this;
    }

    /**
     * Sets the response message.
     *
     * @param string $message
     * @return $this
     */
    public function setMessage(string $message): static
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Sets the response title.
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Generates a JSON response with data.
     *
     * @param array<string, mixed> $data
     * @return JsonResponse
     */
    public function respond(array $data): JsonResponse
    {
        return response()->json(
            [
                'message' => $this->message,
                'code' => $this->responseCode,
                'data' => $data,
            ],
            $this->responseCode
        );
    }

    /**
     * Generates a JSON response for exceptions with additional data.
     *
     * @param Exception $exception
     * @param array<string, mixed> $data
     * @param string $title
     * @return JsonResponse
     */
    public function exceptionRespond(Exception $exception, array $data = [], string $title = 'Error'): JsonResponse
    {
        return response()->json([
            'title' => $title,
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'data' => $data
        ], $exception->getCode() ? $exception->getCode() : 500);
    }

    /**
     * Generates a JSON response for exceptions without data.
     *
     * @param Exception $exception
     * @param string $title
     * @return JsonResponse
     */
    public function respondWithExceptionError(Exception $exception, string $title = 'Error'): JsonResponse
    {
        return response()->json(
            [
                'title' => $title,
                'message' => $exception->getMessage(),
                'code' => $exception->getCode()
            ],
            $exception->getCode() ? $exception->getCode() : 500
        );
    }

    /**
     * Generates an error JSON response.
     *
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    protected function errorResponse(string $message, int $code): JsonResponse
    {
        return response()->json(['message' => $message, 'code' => $code], $code);
    }

    /**
     * Generates a success JSON response.
     *
     * @param array<string, mixed> $data
     * @param int $code
     * @return JsonResponse
     */
    private function successResponse(array $data, int $code): JsonResponse
    {
        return response()->json($data, $code);
    }
}
