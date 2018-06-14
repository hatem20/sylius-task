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
//    public function showAction(Request $request): Response
//    {
//        $configuration = $this->requestConfigurationFactory->create($this->metadata, $request);
//
//        $this->isGrantedOr403($configuration, ResourceActions::SHOW);
//        $product = $this->findOr404($configuration);
//
//        $recommendationServiceApi = $this->get('app.recommendation_service_api');
//
//        $recommendedProducts = $recommendationServiceApi->getRecommendedProducts($product);
//
//        $this->eventDispatcher->dispatch(ResourceActions::SHOW, $configuration, $product);
//
//        $view = View::create($product);
//
//        if ($configuration->isHtmlRequest()) {
//            $view
//                ->setTemplate($configuration->getTemplate(ResourceActions::SHOW . '.html'))
//                ->setTemplateVar($this->metadata->getName())
//                ->setData([
//                    'configuration' => $configuration,
//                    'metadata' => $this->metadata,
//                    'resource' => $product,
//                    'recommendedProducts' => $recommendedProducts,
//                    $this->metadata->getName() => $product,
//                ])
//            ;
//        }
//
//        return $this->viewHandler->handle($configuration, $view);
//    }
}