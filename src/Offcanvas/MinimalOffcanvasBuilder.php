<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Offcanvas;

use Hv\Offcanvas\Cart\AddToCartIntentExtractorInterface;
use Hv\Offcanvas\Cart\LastAddedLineItemFinderInterface;
use Shopware\Core\Checkout\Cart\SalesChannel\CartService;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

final readonly class MinimalOffcanvasBuilder implements MinimalOffcanvasBuilderInterface
{
    public function __construct(
        private CartService $cartService,
        private AddToCartIntentExtractorInterface $extractor,
        private LastAddedLineItemFinderInterface $finder,
    ) {}

    public function build(RequestDataBag $requestDataBag, SalesChannelContext $context): ?MinimalOffcanvasView
    {
        $intent = $this->extractor->fromDataBag($requestDataBag);
        $cart = $this->cartService->getCart($context->getToken(), $context);
        $last = $this->finder->find($intent, $cart);

        return $last ? new MinimalOffcanvasView($last, $cart) : null;
    }
}
