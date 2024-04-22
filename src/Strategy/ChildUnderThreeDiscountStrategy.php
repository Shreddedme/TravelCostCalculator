<?php

namespace App\Strategy;

use App\DTO\TravelCostDto;
use App\Interface\DiscountStrategy;

class ChildUnderThreeDiscountStrategy implements DiscountStrategy
{
    public function isSupported(TravelCostDto $travelCostDto): bool
    {
        $age = $travelCostDto->getChildAge()->diff($travelCostDto->getTravelStartDate())->y;
        return $age < 3;
    }

    public function calculate(TravelCostDto $travelCostDto): float
    {
        return 0;
    }
}