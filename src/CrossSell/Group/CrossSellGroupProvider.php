<?php

declare(strict_types=1);

namespace Hv\Offcanvas\CrossSell\Group;

use Shopware\Core\Content\Product\SalesChannel\CrossSelling\AbstractProductCrossSellingRoute;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\HttpFoundation\Request;

final readonly class CrossSellGroupProvider implements CrossSellGroupProviderInterface
{
    public function __construct(
        private AbstractProductCrossSellingRoute $route,
    ) {}

    public function getLookup(string $productId, SalesChannelContext $context): CrossSellLookup
    {
        $criteria = (new Criteria())->setTitle('hv-offcanvas-cross-selling');
        $request = Request::create('', 'GET', [
            // 'limit' => TODO - limit the number of products in each group
        ]);
        $result = $this->route->load($productId, $request, $context, $criteria);

        return CrossSellLookup::fromCollection($result->getResult());
    }
}
