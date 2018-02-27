<?php

namespace ToolGun\StockPortfolioBundle\Service\Model;


interface ValuationServiceInterface
{
    const BUY = 'buy';

    const SELL = 'sell';

    /**
     * Calculate the valuation and profit
     *
     * @return
     */
    public function calculate();
}