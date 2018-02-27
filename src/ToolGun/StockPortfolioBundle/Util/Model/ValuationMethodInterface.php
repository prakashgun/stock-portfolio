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
     * Get the total profit
     * @return mixed
     */
    public function getTotalProfit(): float;

    /**
     * Get the value of total holdings
     *
     * @return mixed
     */
    public function getTotalEquityValue(): float;

    /**
     * The valaution result
     *
     * @return float
     */
    public function getValuation(): float;

    /**
     * Add a buy transaction
     *
     * @param string $instrumentName
     * @param int $quantity
     * @param float $price
     * @return ValuationMethodInterface
     */
    public function addBuy(string $instrumentName, int $quantity, float $price): ValuationMethodInterface;

    /**
     * Add a sale transaction
     *
     * @param string $instrumentName
     * @param int $quantity
     * @param float $price
     * @return ValuationMethodInterface
     */
    public function addSale(string $instrumentName, int $quantity, float $price): ValuationMethodInterface;

    /**
     * Add current price of the stock
     *
     * @param string $instrumentName
     * @param float $price
     * @return ValuationMethodInterface
     */
    public function addCurrentPrice(string $instrumentName, float $price): ValuationMethodInterface;

    /**
     * Calculate the profit of all stocks
     *
     * @return bool
     */
    public function calculateProfit(): bool;

    /**
     * Total sales price of stocks
     *
     * @param string $instrumentName
     * @return int
     */
    public function totalSalesPrice(string $instrumentName): int;

    /**
     * Number of stocks sold
     *
     * @param string $instrumentName
     * @return int
     */
    public function totalSalesQuantity(string $instrumentName): int;

    /**
     * Total number of stocks bought
     *
     * @param string $instrumentName
     * @return int
     */
    public function totalBuysQuantity(string $instrumentName): int;

    /**
     * Calculate currently how much of price holdings
     * @return bool
     */
    public function calculateEquityValue(): bool;

    /**
     * Calculate the total valuation of the stocks
     *
     * @return bool
     */
    public function calculateValuation(): bool;
}