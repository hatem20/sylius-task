<?php

namespace AppBundle\Controller;

use FOS\RestBundle\View\View;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sylius\Component\Resource\ResourceActions;

class ProductController extends ResourceController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function showAction(Request $request): Response
    {
        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);

        $this->isGrantedOr403($configuration, ResourceActions::SHOW);
        $resource = $this->findOr404($configuration);

        $this->eventDispatcher->dispatch(ResourceActions::SHOW, $configuration, $resource);

        $repository = $this->container->get('app.repository.constant');

        //0 sum of all stock rooms and 1 only default stock room

        if ($repository->isSum()) {

            $stocks = $resource->getProductStock();

            $count = 0;

            foreach ($stocks as $stock) {

                $count += $stock->getAmount();
            }
        } else {

            $stockRoomRepository = $this->container->get('app.repository.stockroom');

            $productStockRepository = $this->container->get('app.repository.product_stock');

            $defaultStockRoomId = $stockRoomRepository->getDefaultStockRoom();

            $defaultStockRoomAmount = $productStockRepository->getAmountByProductIdAndStockRoomId($resource->getId(), $defaultStockRoomId);

            $count = $defaultStockRoomAmount;
        }

        $view = View::create($resource);

        if ($configuration->isHtmlRequest()) {
            $view
                ->setTemplate($configuration->getTemplate(ResourceActions::SHOW . '.html'))
                ->setTemplateVar($this->metadata->getName())
                ->setData([
                    'configuration' => $configuration,
                    'metadata' => $this->metadata,
                    'resource' => $resource,
                    'count'=> $count,
                    $this->metadata->getName() => $resource,
                ])
            ;
        }

        return $this->viewHandler->handle($configuration, $view);
    }
}