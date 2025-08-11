<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Cart;

use Shopware\Core\Checkout\Cart\Cart;
use Shopware\Core\Checkout\Cart\LineItem\LineItem;

final class LastAddedLineItemFinder implements LastAddedLineItemFinderInterface
{
    public function find(AddToCartIntent $intent, Cart $cart): ?LineItem
    {
        $id = $intent->lastReferencedId();
        if ($id === null) {
            return null;
        }

        foreach ($cart->getLineItems()->filterType(LineItem::PRODUCT_LINE_ITEM_TYPE) as $item) {
            if ($item->getReferencedId() === $id) {
                return $item;
            }
        }

        return null;
    }
}
