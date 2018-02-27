<?php

namespace ToolGun\StockPortfolioBundle\Service;

use Symfony\Component\HttpFoundation\Response;
use ToolGun\StockPortfolioBundle\Service\Model\ValuationServiceInterface;
use ToolGun\StockPortfolioBundle\Entity\Transaction;
use ToolGun\StockPortfolioBundle\Repository\TransactionRepository;
use ToolGun\StockPortfolioBundle\Util\Model\ValuationMethodInterface;

class ValuationService implements ValuationServiceInterface
{

    /**
     * @var TransactionRepository
     */
    private $transactionRepository;

    /**
     * @var ValuationMethodInterface
     */
    private $valuationMethod;

    /**
     * ValuationService constructor.
     * @param TransactionRepository $transactionRepository
     * @param ValuationMethodInterface $valuationMethod
     * @internal param string $method
     */
    public function __construct(TransactionRepository $transactionRepository, ValuationMethodInterface $valuationMethod)
    {
        $this->transactionRepository = $transactionRepository;
        $this->valuationMethod = $valuationMethod;
    }

    /**
     * {@inheritdoc}
     */
    public function calculate()
    {
        $transactions = $this->transactionRepository->findAll();

        if (empty($transactions)) {
            throw new \Exception('No transactions exist');
        }

        /** @var Transaction $transaction */
        foreach ($transactions as $transaction) {
            if ($transaction->getBuyOrSell() === self::BUY) {
                $this->valuationMethod->addBuy(
                    $transaction->getInstrument()->getTicker(),
                    $transaction->getQuantity(),
                    $transaction->getPrice()
                );
            } elseif ($transaction->getBuyOrSell() === self::SELL) {
                $this->valuationMethod->addSale(
                    $transaction->getInstrument()->getTicker(),
                    $transaction->getQuantity(),
                    $transaction->getPrice()
                );
            } else {
                throw new \UnexpectedValueException('Unexpected transaction type');
            }
        }

        return $this->valuationMethod->realisedGain();
    }
}