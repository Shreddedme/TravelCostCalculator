<?php

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Attribute\Groups;

class TravelCostDto
{
    #[SerializedName("baseCost")]
    #[Groups(["default"])]
    private ?float $baseCost = null;

    #[SerializedName("travelStartDate")]
    #[Groups(["default"])]
    private ?\DateTime $travelStartDate = null;

    #[SerializedName("childAge")]
    #[Groups(["default"])]
    private ?\DateTime $childAge = null;

    #[SerializedName("paymentDate")]
    #[Groups(["default"])]
    private ?\DateTime $paymentDate = null;


    public function getBaseCost(): ?float
    {
        return $this->baseCost;
    }

    public function setBaseCost(?float $baseCost): self
    {
        $this->baseCost = $baseCost;

        return $this;
    }

    public function getTravelStartDate(): ?\DateTime
    {
        return $this->travelStartDate;
    }

    public function setTravelStartDate(?\DateTime $travelStartDate): self
    {
        $this->travelStartDate = $travelStartDate;

        return $this;
    }

    public function getChildAge(): ?\DateTime
    {
        return $this->childAge;
    }

    public function setChildAge(?\DateTime $childAge): self
    {
        $this->childAge = $childAge;

        return $this;
    }

    public function getPaymentDate(): ?\DateTime
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(?\DateTime $paymentDate): self
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }
}