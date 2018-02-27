<?php

namespace StockPortfolioBundle\Util;

use ToolGun\StockPortfolioBundle\Util\FifoValuationMethod;

class FifoValuationMethodTest extends \PHPUnit_Framework_TestCase
{
    public function testAddBuy()
    {
        $method = new FifoValuationMethod();

        $method->addBuy('AAPL', 50, 116);
        $method->addBuy('AAPL', 50, 120);

        $method->addBuy('GOOG', 50, 800);
        $method->addBuy('GOOG', 10, 810);

        $this->assertEquals(
            [
                'AAPL' => [
                    ['quantity' => 50, 'price' => 116],
                    ['quantity' => 50, 'price' => 120]
                ],
                'GOOG' => [
                    ['quantity' => 50, 'price' => 800],
                    ['quantity' => 10, 'price' => 810]
                ]
            ],
            $method->getBuys()
        );
    }

    public function testAddSale()
    {
        $method = new FifoValuationMethod();
        $method->addSale('AAPL', 80, 128);

        $this->assertEquals(
            [
                'AAPL' => [
                    ['quantity' => 80, 'price' => 128]
                ]
            ],
            $method->getSales()
        );
    }

    public function testTotalSalesPrice()
    {
        $method = new FifoValuationMethod();
        $method->addSale('AAPL', 1, 20);
        $method->addSale('AAPL', 2, 30);


        $this->assertEquals(
            80,
            $method->totalSalesPrice('AAPL')
        );
    }

    public function testTotalSalesQuantity()
    {
        $method = new FifoValuationMethod();
        $method->addSale('AAPL', 1, 20);
        $method->addSale('AAPL', 2, 30);


        $this->assertEquals(
            3,
            $method->totalSalesQuantity('AAPL')
        );
    }

    public function testCalculateProfit()
    {
        $method = new FifoValuationMethod();

        $method->addBuy('AAPL', 50, 116);
        $method->addBuy('AAPL', 50, 120);

        $method->addSale('AAPL', 80, 128);

        $method->calculateProfit();

        $this->assertEquals(
            [
                'AAPL' => 840
            ],
            $method->getProfit()
        );
    }

    public function testCalculateProfitWithSmallSales()
    {
        $method = new FifoValuationMethod();

        $method->addBuy('AAPL', 50, 116);
        $method->addBuy('AAPL', 50, 120);

        $method->addSale('AAPL', 30, 128);

        $method->calculateProfit();

        $this->assertEquals(
            [
                'AAPL' => 360
            ],
            $method->getProfit()
        );
    }

    public function testCalculateProfitWithNoActualSales()
    {
        $method = new FifoValuationMethod();

        $method->addBuy('GOOG', 50, 800);
        $method->addBuy('GOOG', 10, 810);

        $method->calculateProfit();

        $this->assertEquals(
            [
                'GOOG' => 0
            ],
            $method->getProfit()
        );
    }

    public function testAddCurrentPrice()
    {
        $method = new FifoValuationMethod();
        $method->addCurrentPrice('AAPL', 136);
        $method->addCurrentPrice('GOOG', 849);

        $this->assertEquals(
            [
                'AAPL' => 136,
                'GOOG' => 849
            ],
            $method->getCurrentPrices()
        );
    }

    public function testTotalBuysQuantity()
    {
        $method = new FifoValuationMethod();

        $method->addBuy('AAPL', 50, 116);
        $method->addBuy('AAPL', 50, 120);

        $this->assertEquals(
            100,
            $method->totalBuysQuantity('AAPL')
        );
    }

    public function testCalculateEquityValue()
    {
        $method = new FifoValuationMethod();

        $method->addBuy('AAPL', 50, 116);
        $method->addBuy('AAPL', 50, 120);
        $method->addSale('AAPL', 80, 128);


        $method->addBuy('GOOG', 50, 800);
        $method->addBuy('GOOG', 10, 810);

        $method->addCurrentPrice('AAPL', 136);
        $method->addCurrentPrice('GOOG', 849);

        $method->calculateEquityValue();

        $this->assertEquals(
            [
                'AAPL' => 2720,
                'GOOG' => 50940
            ],
            $method->getEquityValue()
        );
    }

    public function testTotalProfit()
    {
        $method = new FifoValuationMethod();

        $method->addBuy('AAPL', 50, 116);
        $method->addBuy('AAPL', 50, 120);
        $method->addSale('AAPL', 80, 128);


        $method->addBuy('GOOG', 50, 800);
        $method->addBuy('GOOG', 10, 810);

        $method->addCurrentPrice('AAPL', 136);
        $method->addCurrentPrice('GOOG', 849);

        $method->calculateProfit();
        $method->calculateEquityValue();

        $this->assertEquals(
            840,
            $method->getTotalProfit()
        );
    }

    public function testValuation()
    {
        $method = new FifoValuationMethod();

        $method->addBuy('AAPL', 50, 116);
        $method->addBuy('AAPL', 50, 120);
        $method->addSale('AAPL', 80, 128);


        $method->addBuy('GOOG', 50, 800);
        $method->addBuy('GOOG', 10, 810);

        $method->addCurrentPrice('AAPL', 136);
        $method->addCurrentPrice('GOOG', 849);

        $method->calculateProfit();
        $method->calculateEquityValue();
        $method->calculateValuation();

        $this->assertEquals(
            54500,
            $method->getValuation()
        );
    }

    public function testValuationWhenNoData()
    {
        $method = new FifoValuationMethod();

        $method->calculateProfit();
        $method->calculateEquityValue();
        $method->calculateValuation();

        $this->assertEquals(
            0,
            $method->getValuation()
        );
    }
}