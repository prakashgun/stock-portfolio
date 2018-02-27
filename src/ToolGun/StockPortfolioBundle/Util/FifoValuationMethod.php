<?php

namespace ToolGun\StockPortfolioBundle\Util;

use ToolGun\StockPortfolioBundle\Util\Model\ValuationMethodInterface;

class FifoValuationMethod implements ValuationMethodInterface
{

    private $buys = [];
    private $sales = [];
    private $currentPrices = [];
    private $profit = [];
    private $equityValue = [];
    private $totalProfit = 0;
    private $totalEquityValue = 0;
    private $valuation = 0;

    /**
     * @return array
     */
    public function getBuys(): array
    {
        return $this->buys;
    }

    /**
     * @return array
     */
    public function getSales(): array
    {
        return $this->sales;
    }

    /**
     * @return array
     */
    public function getCurrentPrices(): array
    {
        return $this->currentPrices;
    }

    /**
     * @return array
     */
    public function getProfit(): array
    {
        return $this->profit;
    }

    /**
     * @return array
     */
    public function getEquityValue(): array
    {
        return $this->equityValue;
    }

    /**
     * @return mixed
     */
    public function getTotalProfit(): float
    {
        return $this->totalProfit;
    }

    /**
     * @return mixed
     */
    public function getTotalEquityValue(): float
    {
        return $this->totalEquityValue;
    }

    /**
     * @return float
     */
    public function getValuation(): float
    {
        return $this->valuation;
    }

    public function addBuy(string $instrumentName, int $quantity, float $price): ValuationMethodInterface
    {
        $this->buys[$instrumentName][] = ['quantity' => $quantity, 'price' => $price];

        return $this;
    }

    public function addSale(string $instrumentName, int $quantity, float $price): ValuationMethodInterface
    {
        $this->sales[$instrumentName][] = ['quantity' => $quantity, 'price' => $price];

        return $this;
    }

    public function addCurrentPrice(string $instrumentName, float $price): ValuationMethodInterface
    {
        $this->currentPrices[$instrumentName] = $price;

        return $this;
    }

    public function calculateProfit(): bool
    {
        $totalProfit = 0;

        foreach ($this->buys as $instrument => $buys) {
            $totalSalesQuantity = $this->totalSalesQuantity($instrument);
            $totalSalesPrice = $this->totalSalesPrice($instrument);

            if ($totalSalesQuantity === 0) {
                $this->profit[$instrument] = 0;
                break;
            }

            if (!empty($buys)) {

                $totalFifoSalesQuantity = 0;
                $totalFifoSalesPrice = 0;

                foreach ($buys as $buy) {

                    if ($totalSalesQuantity === $totalFifoSalesQuantity) {
                        break;
                    }

                    $unitQuantity = $buy['quantity'];

                    if (($totalFifoSalesQuantity + $unitQuantity) > $totalSalesQuantity) {
                        $unitQuantity = $totalSalesQuantity - $totalFifoSalesQuantity;

                        if ($unitQuantity > $buy['quantity']) {
                            $unitQuantity = $buy['quantity'];
                        }
                    }

                    $totalFifoSalesQuantity += $unitQuantity;
                    $totalFifoSalesPrice += ($unitQuantity * $buy['price']);
                }

                $this->profit[$instrument] = $totalSalesPrice - $totalFifoSalesPrice;
                $totalProfit += $this->profit[$instrument];
            }
        }

        $this->totalProfit = $totalProfit;

        return true;
    }

    public function totalSalesPrice(string $instrumentName): int
    {
        if (!isset($this->sales[$instrumentName])) {
            return 0;
        }

        $total = 0;

        foreach ($this->sales[$instrumentName] as $sale) {
            $total += ($sale['quantity'] * $sale['price']);
        }

        return $total;
    }

    public function totalSalesQuantity(string $instrumentName): int
    {
        if (!isset($this->sales[$instrumentName])) {
            return 0;
        }

        $total = 0;

        foreach ($this->sales[$instrumentName] as $sale) {
            $total += $sale['quantity'];
        }

        return $total;
    }

    public function totalBuysQuantity(string $instrumentName): int
    {
        if (!isset($this->buys[$instrumentName])) {
            return 0;
        }

        $total = 0;

        foreach ($this->buys[$instrumentName] as $buy) {
            $total += $buy['quantity'];
        }

        return $total;
    }

    public function calculateEquityValue(): bool
    {
        $totalEquityValue = 0;

        foreach ($this->buys as $instrument => $buys) {
            if (!isset($this->currentPrices[$instrument])) {
                throw new \UnexpectedValueException("Current price not set for instrument " . $instrument);
            }

            $remainingShares = $this->totalBuysQuantity($instrument) - $this->totalSalesQuantity($instrument);

            $equityValue = $remainingShares * $this->currentPrices[$instrument];
            $this->equityValue[$instrument] = $equityValue;
            $totalEquityValue += $equityValue;
        }

        $this->totalEquityValue = $totalEquityValue;

        return true;
    }

    public function calculateValuation()
    {
        $this->valuation = $this->totalProfit + $this->totalEquityValue;
    }
}