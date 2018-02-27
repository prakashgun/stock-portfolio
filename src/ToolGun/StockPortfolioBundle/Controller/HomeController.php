<?php

namespace ToolGun\StockPortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        $transactions = $this->get('tool_gun_stock_portfolio.repository.transaction_repository')->findAll();

        return $this->render('@ToolGunStockPortfolio/Home/index.html.twig', [
            'transactions' => $transactions
        ]);
    }

    public function valuationAction($method = 'fifo')
    {
        $valuationService = null;

        /**
         * Strategy pattern to decide which valuation method service to choose.
         * https://en.wikipedia.org/wiki/Strategy_pattern
         */
        switch ($method) {
            case 'fifo':
                $valuationService = $this->get('tool_gun.service.fifo_valuation_service');
                break;
            case 'average':
                $valuationService = $this->get('tool_gun.service.average_valuation_service');
                break;
            default:
                break;
        }

        if (empty($valuationService)) {
            throw new \InvalidArgumentException('Unknown valuation method');
        }

        try {
            $realizedProfit = $valuationService->calculate();
        } catch (\Exception $exception) {
            //TODO: Error in calculation. Log the message
        }

        return $this->render('@ToolGunStockPortfolio/Home/valuation.html.twig', [
            'realizedProfit' => $realizedProfit
        ]);
    }
}
