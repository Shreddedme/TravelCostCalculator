<?php

namespace App\Strategy;

use App\DTO\TravelCostDto;
use App\Interface\DiscountStrategy;

class EarlyBookingOctoberToJanuaryDiscountStrategy implements DiscountStrategy
{
    public function isSupported(TravelCostDto $travelCostDto): bool
    {
        $travelMonthDay = $travelCostDto->getTravelStartDate()->format('m-d');
        return $travelMonthDay >= '10-01' && $travelMonthDay <= '01-14';
    }

    public function calculate(TravelCostDto $travelCostDto): float
    {
        $paymentDate = $travelCostDto->getPaymentDate();
        if ($paymentDate === null) {
            throw new \InvalidArgumentException('Payment date is required for early booking discount');
        }

        $interval = $travelCostDto->getTravelStartDate()->diff($paymentDate);
        $monthsBeforeStart = $interval->y * 12 + $interval->m;

        $discount = 0;
        if ($monthsBeforeStart >= 5) {
            $discount = 0.07;
        } elseif ($monthsBeforeStart >= 4) {
            $discount = 0.05;
        } elseif ($monthsBeforeStart >= 3) {
            $discount = 0.03;
        }

        return $travelCostDto->getBaseCost() - min($travelCostDto->getBaseCost() * $discount, self::MAX_PAYMENT_DATE_DISCOUNT);
    }
}