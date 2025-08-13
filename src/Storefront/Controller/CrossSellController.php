<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Storefront\Controller;

use Hv\Offcanvas\CrossSell\Select\CrossSellSelectionService;
use Shopware\Core\PlatformRequest;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Shopware\Storefront\Framework\Routing\StorefrontRouteScope;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(defaults: [PlatformRequest::ATTRIBUTE_ROUTE_SCOPE => [StorefrontRouteScope::ID]])]
final class CrossSellController extends StorefrontController
{
    public function __construct(
        private readonly CrossSellSelectionService $selection,
    ) {}

    // NOTE: Personalized XHR fragment. Confirm infra/CDN doesn’t cache it.
    // If needed, add a Response subscriber to set `no-store` for this route.
    #[Route(
        path: '/hv/offcanvas/cross-sell/{productId}',
        name: 'frontend.hv.offcanvas.cross_sell',
        requirements: ['productId' => '[0-9A-Fa-f]{32}'],
        methods: ['GET'],
    )]
    public function load(string $productId, Request $request, SalesChannelContext $context): Response
    {
        if (!$request->isXmlHttpRequest()) {
            throw $this->createNotFoundException();
        }

        $element = $this->selection->pick($productId, $context);

        if ($element === null) {
            return new Response('', Response::HTTP_NO_CONTENT);
        }

        return $this->renderStorefront(
            '@HvOffcanvasCrossSell/storefront/component/checkout/_offcanvas-cross-sell.html.twig',
            [
                'products' => $element->getProducts(),
            ],
        );
    }
}
