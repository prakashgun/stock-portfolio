<?php

namespace ToolGun\StockPortfolioBundle\Util;

use ToolGun\StockPortfolioBundle\Util\Model\ValuationMethodInterface;

class FifoValuationMethod implements ValuationMethodInterface
{

    private $buys = [];
    private $sales = [];
    private $profit = [];

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
    public function getProfit(): array
    {
        return $this->profit;
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

    public function realisedGain(): array
    {

    }

    public function calculateProfit(): bool
    {
        foreach ($this->buys as $instrument => $buys) {
            $totalSalesQuantity = $this->totalSalesQuantity($instrument);
            $totalSalesPrice = $this->totalSalesPrice($instrument);


            if ($totalSalesQuantity === 0) {
                return true;
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
            }
        }

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
}