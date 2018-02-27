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

    /**
     * @return array
     */
    public function getCurrentPrices(): array;

    /**
     * @return array
     */
    public function getProfit(): array;

    /**
     * @return array
     */
    public function getEquityValue(): array;

    /**
     * @return mixed
     */
    public function getTotalProfit(): float;

    /**
     * @return mixed
     */
    public function getTotalEquityValue(): float;

    /**
     * @return float
     */
    public function getValuation(): float;

    public function addBuy(string $instrumentName, int $quantity, float $price): ValuationMethodInterface;

    public function addSale(string $instrumentName, int $quantity, float $price): ValuationMethodInterface;

    public function addCurrentPrice(string $instrumentName, float $price): ValuationMethodInterface;

    public function calculateProfit(): bool;

    public function totalSalesPrice(string $instrumentName): int;

    public function totalSalesQuantity(string $instrumentName): int;

    public function totalBuysQuantity(string $instrumentName): int;

    public function calculateEquityValue(): bool;

    public function calculateValuation(): bool;
}