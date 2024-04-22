<?php

namespace App\ValueResolver;

use App\DTO\TravelCostDto;
use App\Validator\DateValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;

class JsonRequestValueResolver implements ValueResolverInterface
{
    public function __construct(
        private SerializerInterface $serializer,
        private DateValidator $dateValidator
    )
    {}

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $jsonContent = $request->getContent();

        try {
            $context = ['groups' => 'default'];
            $travelCostDto = $this->serializer->deserialize($jsonContent, TravelCostDto::class, 'json', $context);
        } catch (NotEncodableValueException $e) {
            throw new BadRequestHttpException('Invalid format', $e);
        }

        if ($travelCostDto === null) {
            throw new \InvalidArgumentException('Invalid JSON');
        }

        $this->dateValidator->validate($travelCostDto);

        yield $travelCostDto;
    }
}