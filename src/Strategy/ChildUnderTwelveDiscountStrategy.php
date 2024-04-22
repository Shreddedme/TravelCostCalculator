<?php

namespace App\Strategy;

use App\DTO\TravelCostDto;
use App\Interface\DiscountStrategy;

class ChildUnderTwelveDiscountStrategy implements DiscountStrategy
{
    public function isSupported(TravelCostDto $travelCostDto): bool
    {
        $age = $travelCostDto->getChildAge()->diff($travelCostDto->getTravelStartDate())->y;
        return $age >= 6 && $age < 12;
    }

    public function calculate(TravelCostDto $travelCostDto): float
    {
        return min($travelCostDto->getBaseCost() * 0.3, self::MAX_AGE_DISCOUNT);
    }
}