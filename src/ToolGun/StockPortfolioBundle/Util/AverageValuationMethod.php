<?php

namespace ToolGun\StockPortfolioBundle\Util;

use ToolGun\StockPortfolioBundle\Util\Model\ValuationMethodInterface;

class AverageValuationMethod implements ValuationMethodInterface
{

    public function addBuy(string $instrumentName, int $quantity, float $price): ValuationMethodInterface
    {
        // TODO: Implement addBuy() method.
        return $this;
    }

    public function addSale(string $instrumentName, int $quantity, float $price): ValuationMethodInterface
    {
        // TODO: Implement addSell() method.
        return $this;
    }

    public function realisedGain(): float
    {
        return 0;
    }

    /**
     * @return array
     */
    public function getBuys(): array
    {
        // TODO: Implement getBuys() method.
    }

    /**
     * @return array
     */
    public function getSales(): array
    {
        // TODO: Implement getSales() method.
    }
}