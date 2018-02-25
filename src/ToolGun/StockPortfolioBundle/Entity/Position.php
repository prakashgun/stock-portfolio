<?php

namespace ToolGun\StockPortfolioBundle\Entity;

/**
 * Position
 */
class Position
{
    const VALUATION_METHOD_FIFO = 'fifo';

    CONST VALUATION_METHOD_AVERAGE = 'average';

    /**
     * @var int
     */
    private $id;

    /**
     * @var float
     */
    private $valuation;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $method;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set valuation.
     *
     * @param float $valuation
     *
     * @return Position
     */
    public function setValuation($valuation): Position
    {
        $this->valuation = $valuation;

        return $this;
    }

    /**
     * Get valuation.
     *
     * @return float
     */
    public function getValuation(): float
    {
        return $this->valuation;
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
     * @return Position
     */
    public function setDate(\DateTime $date): Position
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return Position
     */
    public function setMethod(string $method): Position
    {
        if (!in_array($method, [self::VALUATION_METHOD_FIFO, self::VALUATION_METHOD_AVERAGE])) {
            throw new \InvalidArgumentException("Invalid valuation method");
        }

        $this->method = $method;
        return $this;
    }
}
