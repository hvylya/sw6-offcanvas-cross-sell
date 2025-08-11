<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Cart;

use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;

final class AddToCartIntentExtractor implements AddToCartIntentExtractorInterface
{
    public function fromDataBag(RequestDataBag $requestDataBag): AddToCartIntent
    {
        $lineItems = $requestDataBag->get('lineItems');

        if (!$lineItems instanceof RequestDataBag) {
            return new AddToCartIntent(null);
        }

        $last = null;

        foreach ($lineItems as $lineItem) {
            if ($lineItem instanceof RequestDataBag) {
                $referencedId = trim($lineItem->getString('referencedId'));
                if ($referencedId !== '') {
                    $last = $referencedId;
                }
            }
        }

        return new AddToCartIntent($last);
    }
}
