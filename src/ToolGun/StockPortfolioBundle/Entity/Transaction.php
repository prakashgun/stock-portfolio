<?php

namespace ToolGun\StockPortfolioBundle\Entity;

/**
 * Transaction
 */
class Transaction
{

    const BUY = 'buy';

    const SELL = "sell";

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $buyOrSell;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @var float
     */
    private $price;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var Position
     */
    private $position;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getBuyOrSell(): string
    {
        return $this->buyOrSell;
    }

    /**
     * @param string $buyOrSell
     * @return Transaction
     */
    public function setBuyOrSell(string $buyOrSell): Transaction
    {
        if (!in_array($buyOrSell, [self::BUY, self::SELL])) {
            throw new \InvalidArgumentException("Invalid buy or sell status");
        }

        $this->buyOrSell = $buyOrSell;
        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     * @return Transaction
     */
    public function setQuantity(int $quantity): Transaction
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Transaction
     */
    public function setPrice(float $price): Transaction
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return Transaction
     */
    public function setDate(\DateTime $date): Transaction
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return Position
     */
    public function getPosition(): Position
    {
        return $this->position;
    }

    /**
     * @param Position $position
     * @return Transaction
     */
    public function setPosition(Position $position): Transaction
    {
        $this->position = $position;
        return $this;
    }
}