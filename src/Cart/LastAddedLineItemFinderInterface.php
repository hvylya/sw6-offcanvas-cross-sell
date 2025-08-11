<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Cart;

use Shopware\Core\Checkout\Cart\Cart;
use Shopware\Core\Checkout\Cart\LineItem\LineItem;

interface LastAddedLineItemFinderInterface
{
    public function find(AddToCartIntent $intent, Cart $cart): ?LineItem;
}
