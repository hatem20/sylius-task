<?php
/**
 * Created by PhpStorm.
 * User: hatem
 * Date: 6/16/18
 * Time: 5:15 PM
 */

namespace AppBundle\EventListener;


class ProductUpdateListener
{
    public function test($event)
    {
        dump($event);exit;
    }
}