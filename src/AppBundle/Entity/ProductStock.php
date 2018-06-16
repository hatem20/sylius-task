<?php
/**
 * Created by PhpStorm.
 * User: hatem
 * Date: 6/15/18
 * Time: 4:35 AM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;

/** @ORM\Table(name="product_stock") @ORM\Entity() */
class ProductStock implements ResourceInterface
{
    /** ORM\Column(type="integer") */
    protected $amount;

    protected $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="StockRoom", inversedBy="productStock")
     * @ORM\JoinColumn(name="stock_id", referencedColumnName="id", nullable=false)
     */
    protected $stockRoom;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productStock")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     */
    protected $product;

    /**
     * @return mixed
     */
    public function getStockRoom()
    {
        return $this->stockRoom;
    }

    /**
     * @param mixed $stockRoom
     */
    public function setStockRoom($stockRoom): void
    {
        $this->stockRoom = $stockRoom;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product): void
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }
}