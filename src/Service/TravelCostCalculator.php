<?php

namespace App\Service;

use App\DTO\TravelCostDto;
use App\Interface\DiscountStrategy;

class TravelCostCalculator
{
    /** @var DiscountStrategy[] */
    private array $ageDiscountStrategies;

    /** @var DiscountStrategy[] */
    private array $earlyBookingDiscountStrategies;

    /**
     * @param DiscountStrategy[] $ageDiscountStrategies
     * @param DiscountStrategy[] $earlyBookingDiscountStrategies
     */
    public function __construct(array $ageDiscountStrategies, array $earlyBookingDiscountStrategies)
    {
        $this->ageDiscountStrategies = $ageDiscountStrategies;
        $this->earlyBookingDiscountStrategies = $earlyBookingDiscountStrategies;
    }

    public function calculateTravelCost(TravelCostDto $travelCostDto): float
    {
        $baseCost = $travelCostDto->getBaseCost();
        $totalDiscount = 0;

        foreach ($this->ageDiscountStrategies as $strategy) {
            if ($strategy->isSupported($travelCostDto)) {
                $totalDiscount = $strategy->calculate($travelCostDto);
            }
        }

        foreach ($this->earlyBookingDiscountStrategies as $strategy) {
            if ($strategy->isSupported($travelCostDto)) {
                $totalDiscount = $strategy->calculate($travelCostDto);
                break;
            }
        }

        return $baseCost - $totalDiscount;
    }
}