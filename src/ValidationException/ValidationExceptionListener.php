<?php

namespace App\ValidationException;

use App\ErrorHandling\ErrorResponse;
use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Serializer\SerializerInterface;

class ValidationExceptionListener
{
    public function __construct(
        private SerializerInterface $serializer,
    )
    {}

    public const JSON = 'application/json';
    public function onKernelException(ExceptionEvent $event): void
    {
        $acceptHeader = $event->getRequest()->headers->get('Accept');
        $exception = $event->getThrowable();

        if ($acceptHeader !== self::JSON) {
            return;
        }

        if ($exception instanceof ValidationException) {
            $response = new JsonResponse($this->buildData($exception), Response::HTTP_BAD_REQUEST, [], true);
        } else {
            return;
        }

        $event->stopPropagation();
        $event->setResponse($response);
    }

    public function buildData(ValidationException $exception): string
    {
        $errorResponse = new ErrorResponse();

        foreach ($exception->getValidationErrors() as $error) {
            $errorResponse->addError($error);
        }

        return $this->serializer->serialize($errorResponse, 'json');
    }
}