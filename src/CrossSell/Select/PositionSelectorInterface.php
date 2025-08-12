<?php

declare(strict_types=1);

namespace Hv\Offcanvas\CrossSell\Select;

use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

interface PositionSelectorInterface
{
    public function select(ProductEntity $product, SalesChannelContext $context): ?int;
}
