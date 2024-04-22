<?php

namespace App\Controller;

use App\DTO\TravelCostDto;
use App\Service\TravelCostCalculator;
use App\ValueResolver\JsonRequestValueResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\ValueResolver;
use Symfony\Component\Routing\Attribute\Route;

class TravelCostController extends AbstractController
{
    public function __construct(
        private TravelCostCalculator $calculator
    )
    {}

    #[Route('/api/calculate', name: 'calculate_cost', methods: ['POST'])]
    public function calculateTravelCost(
        #[ValueResolver(JsonRequestValueResolver::class)]
        TravelCostDto $travelCostDto
    ): JsonResponse
    {
        $totalCost = $this->calculator->calculateTravelCost($travelCostDto);

        return $this->json(['Result' => $totalCost]);
    }
}