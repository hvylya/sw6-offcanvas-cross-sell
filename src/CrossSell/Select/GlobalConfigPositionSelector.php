<?php

declare(strict_types=1);

namespace Hv\Offcanvas\CrossSell\Select;

use Hv\Offcanvas\CrossSell\CrossSellKeys;
use Hv\Offcanvas\Util\IntNormalizer;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;

final readonly class GlobalConfigPositionSelector implements PositionSelectorInterface
{
    public function __construct(
        private SystemConfigService $config,
    ) {}

    public function select(ProductEntity $product, SalesChannelContext $context): ?int
    {
        $raw = $this->config->get(CrossSellKeys::PLUGIN_CONFIG_CROSS_SELL_POSITION, $context->getSalesChannelId());

        return IntNormalizer::toPositiveIntOrNull($raw);
    }
}
