<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Storefront\Controller;

use Hv\Offcanvas\Offcanvas\MinimalOffcanvasBuilderInterface;
use Shopware\Core\Checkout\Cart\Cart;
use Shopware\Core\Checkout\Cart\LineItemFactoryHandler\ProductLineItemFactory;
use Shopware\Core\Checkout\Cart\LineItemFactoryRegistry;
use Shopware\Core\Checkout\Cart\SalesChannel\CartService;
use Shopware\Core\Checkout\Promotion\Cart\PromotionItemBuilder;
use Shopware\Core\Content\Product\SalesChannel\AbstractProductListRoute;
use Shopware\Core\Framework\Util\HtmlSanitizer;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\CartLineItemController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class AddToCartOffcanvasControllerDecorator extends CartLineItemController
{
    public function __construct(
        private readonly CartLineItemController $inner,
        CartService $cartService,
        PromotionItemBuilder $promotionItemBuilder,
        ProductLineItemFactory $productLineItemFactory,
        HtmlSanitizer $htmlSanitizer,
        AbstractProductListRoute $productListRoute,
        LineItemFactoryRegistry $lineItemFactoryRegistry,
        private readonly MinimalOffcanvasBuilderInterface $builder,
    ) {
        parent::__construct(
            $cartService,
            $promotionItemBuilder,
            $productLineItemFactory,
            $htmlSanitizer,
            $productListRoute,
            $lineItemFactoryRegistry,
        );
    }

    public function addLineItems(
        Cart $cart,
        RequestDataBag $requestDataBag,
        Request $request,
        SalesChannelContext $context,
    ): Response {
        $response = $this->inner->addLineItems($cart, $requestDataBag, $request, $context);

        if (!$request->isXmlHttpRequest()) {
            return $response;
        }

        $view = $this->builder->build($requestDataBag, $context);
        if ($view === null) {
            return $response;
        }

        // TODO(caveat): We inject minimal `page.cart` only to keep core partials working.
        // Consider basing on `utilities/offcanvas.html.twig` + own view-model to drop this dependency.
        return $this->renderStorefront(
            '@HvOffcanvasCrossSell/storefront/component/checkout/offcanvas-last-item.html.twig',
            [
                'lastAdded' => $view->lastAdded,
                'page' => ['cart' => $view->cart],
            ],
        );
    }
}
