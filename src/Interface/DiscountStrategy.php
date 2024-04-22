<?php

namespace App\Interface;

use App\DTO\TravelCostDto;

interface DiscountStrategy
{
    public const MAX_AGE_DISCOUNT = 4500;
    public const MAX_PAYMENT_DATE_DISCOUNT = 1500;

    public function isSupported(TravelCostDto $travelCostDto): bool;
    public function calculate(TravelCostDto $travelCostDto): float;
}