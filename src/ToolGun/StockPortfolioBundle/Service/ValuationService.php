<?php

namespace ToolGun\StockPortfolioBundle\Service;

use ToolGun\StockPortfolioBundle\Entity\Instrument;
use ToolGun\StockPortfolioBundle\Entity\Transaction;
use ToolGun\StockPortfolioBundle\Repository\InstrumentRepository;
use ToolGun\StockPortfolioBundle\Repository\TransactionRepository;
use ToolGun\StockPortfolioBundle\Service\Model\ValuationServiceInterface;
use ToolGun\StockPortfolioBundle\Util\Model\ValuationMethodInterface;

class ValuationService implements ValuationServiceInterface
{

    /**
     * @var TransactionRepository
     */
    private $transactionRepository;

    /**
     * @var InstrumentRepository
     */
    private $instrumentRepository;

    /**
     * @var ValuationMethodInterface
     */
    private $valuationMethod;

    /**
     * ValuationService constructor.
     *
     * @param TransactionRepository $transactionRepository
     * @param InstrumentRepository $instrumentRepository
     * @param ValuationMethodInterface $valuationMethod
     */
    public function __construct(
        TransactionRepository $transactionRepository,
        InstrumentRepository $instrumentRepository,
        ValuationMethodInterface $valuationMethod)
    {
        $this->transactionRepository = $transactionRepository;
        $this->instrumentRepository = $instrumentRepository;
        $this->valuationMethod = $valuationMethod;
    }

    /**
     * {@inheritdoc}
     */
    public function calculate(): array
    {
        $transactions = $this->transactionRepository->findAll();

        if (empty($transactions)) {
            throw new \Exception('No transactions exist');
        }

        /** @var Transaction $transaction */
        foreach ($transactions as $transaction) {
            if ($transaction->getBuyOrSell() === self::BUY) {
                $instrument = $transaction->getInstrument();

                $this->valuationMethod->addBuy(
                    $instrument->getTicker(),
                    $transaction->getQuantity(),
                    $transaction->getPrice()
                );
            } elseif ($transaction->getBuyOrSell() === self::SELL) {
                $instrument = $transaction->getInstrument();

                $this->valuationMethod->addSale(
                    $instrument->getTicker(),
                    $transaction->getQuantity(),
                    $transaction->getPrice()
                );
            } else {
                throw new \UnexpectedValueException('Unexpected transaction type');
            }
        }

        $instruments = $this->instrumentRepository->findAll();

        /** @var Instrument $instrument */
        foreach ($instruments as $instrument) {
            $this->valuationMethod->addCurrentPrice($instrument->getTicker(), $instrument->getCurrentPrice());
        }

        $this->valuationMethod->calculateProfit();
        $this->valuationMethod->calculateEquityValue();
        $this->valuationMethod->calculateValuation();

        return [
            'profit' => $this->valuationMethod->getTotalProfit(),
            'equity_value' => $this->valuationMethod->getTotalEquityValue(),
            'valuation' => $this->valuationMethod->getValuation()
        ];
    }
}