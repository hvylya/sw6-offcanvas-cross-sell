<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Offcanvas;

use Shopware\Core\Checkout\Cart\Cart;
use Shopware\Core\Checkout\Cart\LineItem\LineItem;

final readonly class MinimalOffcanvasView
{
    public function __construct(
        public LineItem $lastAdded,
        public Cart $cart,
    ) {}
}
