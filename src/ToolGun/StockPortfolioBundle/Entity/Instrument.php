<?php

namespace ToolGun\StockPortfolioBundle\Entity;

/**
 * Instrument
 */
class Instrument
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $ticker;

    /**
     * @var string
     */
    private $name;

    /**
     * @var float
     */
    private $currentPrice;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ticker.
     *
     * @param string $ticker
     *
     * @return Instrument
     */
    public function setTicker($ticker)
    {
        $this->ticker = $ticker;

        return $this;
    }

    /**
     * Get ticker.
     *
     * @return string
     */
    public function getTicker()
    {
        return $this->ticker;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Instrument
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set currentPrice.
     *
     * @param float $currentPrice
     *
     * @return Instrument
     */
    public function setCurrentPrice($currentPrice)
    {
        $this->currentPrice = $currentPrice;

        return $this;
    }

    /**
     * Get currentPrice.
     *
     * @return float
     */
    public function getCurrentPrice()
    {
        return $this->currentPrice;
    }
}
