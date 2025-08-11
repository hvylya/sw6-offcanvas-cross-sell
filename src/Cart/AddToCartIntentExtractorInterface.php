<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Cart;

use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;

interface AddToCartIntentExtractorInterface
{
    public function fromDataBag(RequestDataBag $requestDataBag): AddToCartIntent;
}
