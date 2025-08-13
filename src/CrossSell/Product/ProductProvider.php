<?php

declare(strict_types=1);

namespace Hv\Offcanvas\CrossSell\Product;

use Shopware\Core\Content\Product\ProductCollection;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

final readonly class ProductProvider implements ProductProviderInterface
{
    /** @param EntityRepository<ProductCollection> $productRepository */
    public function __construct(
        private EntityRepository $productRepository,
    ) {}

    public function get(string $productId, SalesChannelContext $context): ?ProductEntity
    {
        $criteria = (new Criteria([$productId]))->setTitle('hv-offcanvas-product');

        return $this->productRepository->search($criteria, $context->getContext())->first();
    }
}
