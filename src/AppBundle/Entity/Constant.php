<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Resource\Model\ResourceInterface;
/**
 * Constant
 *
 * @ORM\Table(name="constant")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConstantRepository")
 */
class Constant implements ResourceInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="sum", type="boolean", unique=true)
     */
    private $sum;


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
     * Set sum.
     *
     * @param bool $sum
     *
     * @return Constant
     */
    public function setSum($sum)
    {
        $this->sum = $sum;

        return $this;
    }

    /**
     * Get sum.
     *
     * @return bool
     */
    public function getSum()
    {
        return $this->sum;
    }
}
