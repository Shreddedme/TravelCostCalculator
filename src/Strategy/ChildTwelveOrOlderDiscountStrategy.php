<?php

namespace App\Strategy;

use App\DTO\TravelCostDto;
use App\Interface\DiscountStrategy;

class ChildTwelveOrOlderDiscountStrategy implements DiscountStrategy
{
    public function isSupported(TravelCostDto $travelCostDto): bool
    {
        $age = $travelCostDto->getChildAge()->diff($travelCostDto->getTravelStartDate())->y;
        return $age >= 12 && $age < 18;
    }

    public function calculate(TravelCostDto $travelCostDto): float
    {
        return $travelCostDto->getBaseCost() * 0.1;
    }
}