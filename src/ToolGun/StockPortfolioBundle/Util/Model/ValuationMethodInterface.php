<?php

namespace ToolGun\StockPortfolioBundle\Util\Model;


interface ValuationMethodInterface
{
    /**
     * @return array
     */
    public function getBuys(): array;

    /**
     * @return array
     */
    public function getSales(): array;

    public function addBuy(string $instrumentName, int $quantity, float $price): ValuationMethodInterface;

    public function addSale(string $instrumentName, int $quantity, float $price): ValuationMethodInterface;

    public function calculateProfit(): bool;
}