<?php

namespace ToolGun\StockPortfolioBundle\Util;

use ToolGun\StockPortfolioBundle\Util\Model\ValuationMethodInterface;

class AverageValuationMethod implements ValuationMethodInterface
{

    /**
     * @return array
     */
    public function getBuys(): array
    {
        // TODO: Implement getBuys() method.
        return [];
    }

    /**
     * @return array
     */
    public function getSales(): array
    {
        // TODO: Implement getSales() method.
        return [];
    }

    /**
     * @return array
     */
    public function getCurrentPrices(): array
    {
        // TODO: Implement getCurrentPrices() method.
        return [];
    }

    /**
     * @return array
     */
    public function getProfit(): array
    {
        // TODO: Implement getProfit() method.
        return [];
    }

    /**
     * @return array
     */
    public function getEquityValue(): array
    {
        // TODO: Implement getEquityValue() method.
        return [];
    }

    /**
     * @return mixed
     */
    public function getTotalProfit(): float
    {
        // TODO: Implement getTotalProfit() method.
        return 0;
    }

    /**
     * @return mixed
     */
    public function getTotalEquityValue(): float
    {
        // TODO: Implement getTotalEquityValue() method.
        return 0;
    }

    /**
     * @return float
     */
    public function getValuation(): float
    {
        // TODO: Implement getValuation() method.
        return 0;
    }

    public function addBuy(string $instrumentName, int $quantity, float $price): ValuationMethodInterface
    {
        // TODO: Implement addBuy() method.
        return $this;
    }

    public function addSale(string $instrumentName, int $quantity, float $price): ValuationMethodInterface
    {
        // TODO: Implement addSale() method.
    }

    public function addCurrentPrice(string $instrumentName, float $price): ValuationMethodInterface
    {
        // TODO: Implement addCurrentPrice() method.
        return $this;
    }

    public function calculateProfit(): bool
    {
        // TODO: Implement calculateProfit() method.
        return true;
    }

    public function totalSalesPrice(string $instrumentName): int
    {
        // TODO: Implement totalSalesPrice() method.
        return 0;
    }

    public function totalSalesQuantity(string $instrumentName): int
    {
        // TODO: Implement totalSalesQuantity() method.
        return 0;
    }

    public function totalBuysQuantity(string $instrumentName): int
    {
        // TODO: Implement totalBuysQuantity() method.
        return 0;
    }

    public function calculateEquityValue(): bool
    {
        // TODO: Implement calculateEquityValue() method.
        return true;
    }

    public function calculateValuation(): bool
    {
        // TODO: Implement calculateValuation() method.
        return 0;
    }
}