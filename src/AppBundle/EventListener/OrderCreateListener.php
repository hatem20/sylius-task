<?php
/**
 * Created by PhpStorm.
 * User: hatem
 * Date: 6/16/18
 * Time: 6:30 PM
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\ProductStock;
use AppBundle\Repository\ProductStockRepository;
use AppBundle\Repository\StockRoomRepository;
use Doctrine\ORM\PersistentCollection;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;

class OrderCreateListener
{
    protected $stockRoomRepositoryService;

    protected $productStockRepositoryService;

    public function __construct(StockRoomRepository $stockRoomRepositoryService,ProductStockRepository $productStockRepositoryService)
    {
        $this->stockRoomRepositoryService = $stockRoomRepositoryService;
        $this->productStockRepositoryService = $productStockRepositoryService;
    }

    public function subtractFromStock(ResourceControllerEvent $event)
    {
        /**
         * @todo validate if all items count in order are sufficient
         */

        $items = $event->getSubject()->getItems();

        //for each item if order Quantity is more than Stock Amount in all stockRooms
        //ignore subtraction for all products
        foreach ($items as $item) {
            $product = $item->getProduct();
            $productStocks = $product->getProductStock();

            $totalAmountInAllStockRooms = 0;

            foreach ($productStocks as $productStock) {
                $totalAmountInAllStockRooms += $productStock->getAmount();
            }

            $orderQuantity = $item->getQuantity();

            if ($orderQuantity > $totalAmountInAllStockRooms) {
                return;
            }
        }

        $defaultStockRoomId = $this->stockRoomRepositoryService->getDefaultStockRoom();

        foreach ($items as $item) {

            $productId = $item->getProduct()->getId();

            $productAmountInStockRoom = $this->productStockRepositoryService
                ->getAmountByProductIdAndStockRoomId($productId, $defaultStockRoomId);

                    $orderQuantity = $item->getQuantity();

            $newAmount = $productAmountInStockRoom - $orderQuantity;

            if ($newAmount >= 0) {
                //subtract from default stock room only
                $this->productStockRepositoryService
                    ->updateStockRoomAmount($defaultStockRoomId, $productId, $newAmount);

            } else {
                //in case default only is not sufficient
                //subtract from another stockroom until fulfill order
                $productStocks = $item->getProduct()->getProductStock();

                //@todo remove this conversion
                $productStocksArray = $this->convertProductStockToArray($productStocks);

                $productStocksDefaultAmount = $this->getDefaultProductStockAmount($productStocksArray, $defaultStockRoomId);

                $remainToBeSubtracted = $orderQuantity - $productStocksDefaultAmount;

                $productStocksArray = $this->removeDefaultProductStockFromArray($productStocksArray, $defaultStockRoomId);

                $productStocksArray = $this->descSortByAmount($productStocksArray);

                $updatedProductStocksArray = array_merge(
                    [['id' => $defaultStockRoomId, 'newAmount' => 0]],
                    $this->handleSubtraction($productStocksArray, $remainToBeSubtracted)
                );

                foreach ($updatedProductStocksArray as $productStocks) {
                    $this->productStockRepositoryService
                        ->updateStockRoomAmount($productStocks['id'], $productId, $productStocks['newAmount']);
                }
            }
        }
    }

    /**
     * @param $productStocksArray array
     * @param $remainToBeSubtracted int after subtract from default
     *
     * @return array new amount values to be updated directly
     *
    */
    private function handleSubtraction(array $productStocksArray, int $remainToBeSubtracted):array
    {
        $productStocksAmounts = [];

        foreach ($productStocksArray as $productStock) {

            if ($remainToBeSubtracted <= $productStock['amount']) {
                $productStocksAmounts[] = ['id' => $productStock['stock_room_id'],'newAmount' => $productStock['amount'] - $remainToBeSubtracted];
                break;
            } else {
                $productStocksAmounts[] = ['id' => $productStock['stock_room_id'],'newAmount' => 0];
                $remainToBeSubtracted = $remainToBeSubtracted - $productStock['amount'];
            }
        }

        return $productStocksAmounts;
    }

    /**
     * @param $productStocksArray array
     * @param $defaultStockRoomId int
     * @return int
    */
    private function getDefaultProductStockAmount(array $productStocksArray, int $defaultStockRoomId):int
    {
        foreach ($productStocksArray as $i => $productStock) {
            if ($productStock['stock_room_id'] == $defaultStockRoomId) {

                return $productStock['amount'];
            }
        }
    }

    /**
     * @param $productStocksArray array
     *
     * @return array
     *
    */
    private function descSortByAmount(array $productStocksArray): array
    {
        usort($productStocksArray, function($a, $b){
            return strcmp($b["amount"], $a["amount"]);
        });

        return $productStocksArray;
    }

    /**
     * @param $productStocksArray array
     * @param $defaultStockRoomId int
     *
     * @return array
    */
    private function removeDefaultProductStockFromArray($productStocksArray, $defaultStockRoomId) :array
    {
        foreach ($productStocksArray as $i => $productStock) {
            if ($productStock['stock_room_id'] == $defaultStockRoomId) {
                unset($productStocksArray[$i]);
            }
        }

        return $productStocksArray;
    }

    /**
     * convert ProductStock representation to array with stockRoomId as key and ProductStock amount as value
    */
    private function convertProductStockToArray($productStocks)
    {
        $productStocksArray = [];

        foreach ($productStocks as $productStock) {
            $productStocksArray[] = ['stock_room_id' => $productStock->getStockRoom()->getId(), 'amount' => $productStock->getAmount()];
        }

        return $productStocksArray;
    }
}