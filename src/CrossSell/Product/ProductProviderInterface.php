<?php

declare(strict_types=1);

namespace Hv\Offcanvas\CrossSell\Product;

use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

interface ProductProviderInterface
{
    public function get(string $productId, SalesChannelContext $context): ?ProductEntity;
}
