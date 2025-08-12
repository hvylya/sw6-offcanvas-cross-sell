<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Tests\Unit\CrossSell;

use Shopware\Core\Content\Product\Aggregate\ProductCrossSelling\ProductCrossSellingEntity;
use Shopware\Core\Content\Product\ProductCollection;
use Shopware\Core\Content\Product\SalesChannel\CrossSelling\CrossSellingElement;

trait CrossSellFixturesTrait
{
    private function makeElement(int $position, int $productCount): CrossSellingElement
    {
        $cross = $this->createStub(ProductCrossSellingEntity::class);
        $cross->method('getPosition')->willReturn($position);

        $products = $this->createStub(ProductCollection::class);
        $products->method('count')->willReturn($productCount);

        $element = $this->createStub(CrossSellingElement::class);
        $element->method('getCrossSelling')->willReturn($cross);
        $element->method('getProducts')->willReturn($products);

        return $element;
    }
}
