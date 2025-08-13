<?php

declare(strict_types=1);

namespace Hv\Offcanvas\CrossSell\Group;

use Shopware\Core\System\SalesChannel\SalesChannelContext;

interface CrossSellGroupProviderInterface
{
    public function getLookup(string $productId, SalesChannelContext $context): CrossSellLookup;
}
