<?php

declare(strict_types=1);

namespace Hv\Offcanvas\CrossSell\Select;

use Hv\Offcanvas\CrossSell\CrossSellKeys;
use Hv\Offcanvas\Util\IntNormalizer;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

final readonly class ProductCustomFieldPositionSelector implements PositionSelectorInterface
{
    public function select(ProductEntity $product, SalesChannelContext $context): ?int
    {
        $raw = ($product->getCustomFields() ?? []) [CrossSellKeys::PRODUCT_CROSS_SELL_POSITION] ?? null;

        return IntNormalizer::toPositiveIntOrNull($raw);
    }
}
