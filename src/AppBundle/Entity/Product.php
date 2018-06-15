<?php
/**
 * Created by PhpStorm.
 * User: hatem
 * Date: 6/15/18
 * Time: 4:42 AM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Core\Model\Product as BaseProduct;

class Product extends BaseProduct
{
//    public function __construct()
//    {
//        parent::__construct();
//        $this->productStock = new ArrayCollection();
//    }

    protected $productStock;

    /**
     * @return mixed
     */
    public function getProductStock()
    {
        return $this->productStock;
    }

    /**
     * @param mixed $productStock
     */
    public function setProductStock($productStock): void
    {
        $this->productStock = $productStock;
    }
}