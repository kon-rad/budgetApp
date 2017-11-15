<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Budget
 *
 * @ORM\Table(name="budget")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TodoRepository")
 */
class Budget
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $amount;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Budget
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return Budget
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }
}

