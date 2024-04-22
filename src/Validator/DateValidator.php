<?php

namespace App\Validator;

use App\DTO\TravelCostDto;
use App\Exception\ValidationException;

class DateValidator
{
    public function validate(TravelCostDto $travelCostDto): void
    {
        $errors = [];

        if ($travelCostDto->getBaseCost() === null || !is_numeric($travelCostDto->getBaseCost())) {
            $errors[] = 'Invalid or missing baseCost';
        }

        if ($travelCostDto->getTravelStartDate() === null || !$this->validateDate($travelCostDto->getTravelStartDate())) {
            $errors[] = 'Invalid or missing travelStartDate';
        }

        if ($travelCostDto->getChildAge() === null || !$this->validateDate($travelCostDto->getChildAge())) {
            $errors[] = 'Invalid or missing childAge';
        }

        if ($travelCostDto->getPaymentDate() !== null && !$this->validateDate($travelCostDto->getPaymentDate())) {
            $errors[] = 'Invalid paymentDate';
        }

        if ($travelCostDto->getTravelStartDate() !== null && $travelCostDto->getPaymentDate() !== null) {
            if ($travelCostDto->getTravelStartDate() < $travelCostDto->getPaymentDate()) {
                $errors[] = 'travelStartDate must be later than paymentDate';
            }
        }

        if (!empty($errors)) {
            throw new ValidationException($errors);
        }
    }

    private function validateDate(\DateTime $date): bool
    {
        $dateTime = \DateTime::createFromFormat('d.m.Y', $date->format('d.m.Y'));
        return $dateTime && $dateTime->format('d.m.Y') === $date->format('d.m.Y');
    }
}