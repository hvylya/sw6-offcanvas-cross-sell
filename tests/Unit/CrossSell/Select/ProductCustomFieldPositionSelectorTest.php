<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Tests\Unit\CrossSell\Select;

use Hv\Offcanvas\CrossSell\Select\ProductCustomFieldPositionSelector;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

#[CoversClass(ProductCustomFieldPositionSelector::class)]
final class ProductCustomFieldPositionSelectorTest extends TestCase
{
    private SalesChannelContext $context;

    protected function setUp(): void
    {
        $this->context = $this->createStub(SalesChannelContext::class);
    }

    public function testReadsPositiveIntFromCustomField(): void
    {
        $selector = new ProductCustomFieldPositionSelector();

        $product = new ProductEntity();
        $product->setCustomFields(['hv_cross_sell_index' => '3']);

        self::assertSame(3, ($selector)->select($product, $this->context));
    }

    public function testReturnsNullForZeroOrEmpty(): void
    {
        $selector = new ProductCustomFieldPositionSelector();

        $product1 = new ProductEntity();
        $product1->setCustomFields(['hv_cross_sell_index' => '0']);

        self::assertNull($selector->select($product1, $this->context));

        $product2 = new ProductEntity();
        $product2->setCustomFields(['hv_cross_sell_index' => '']);
        self::assertNull($selector->select($product2, $this->context));
    }
}
