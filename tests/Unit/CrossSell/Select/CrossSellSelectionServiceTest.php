<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Tests\Unit\CrossSell\Select;

use Hv\Offcanvas\CrossSell\Group\CrossSellGroupProviderInterface;
use Hv\Offcanvas\CrossSell\Group\CrossSellLookup;
use Hv\Offcanvas\CrossSell\Product\ProductProviderInterface;
use Hv\Offcanvas\CrossSell\Select\CrossSellSelectionService;
use Hv\Offcanvas\CrossSell\Select\PositionSelectorInterface;
use Hv\Offcanvas\Tests\Unit\CrossSell\CrossSellFixturesTrait;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\Content\Product\SalesChannel\CrossSelling\CrossSellingElement;
use Shopware\Core\Content\Product\SalesChannel\CrossSelling\CrossSellingElementCollection;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

#[CoversClass(CrossSellSelectionService::class)]
final class CrossSellSelectionServiceTest extends TestCase
{
    use CrossSellFixturesTrait;

    private SalesChannelContext $context;
    private ProductProviderInterface $productProvider;
    private CrossSellGroupProviderInterface $groupProvider;

    protected function setUp(): void
    {
        $this->context = $this->createStub(SalesChannelContext::class);
        $this->productProvider = $this->createStub(ProductProviderInterface::class);
        $this->groupProvider = $this->createStub(CrossSellGroupProviderInterface::class);
    }

    public function testPicksFirstMatchingSelectorElseFallsBackToFirstNonEmpty(): void
    {
        $productId = 'example-product-id';

        $product = new ProductEntity();
        $product->setId($productId);
        $this->productProvider->method('get')->willReturn($product);

        // Groups: 1 = empty, 2 = non-empty (should be picked), 3 = non-empty
        $group1 = $this->makeElement(1, 0);
        $group2 = $this->makeElement(2, 2);
        $group3 = $this->makeElement(3, 1);

        $lookup = CrossSellLookup::fromCollection(new CrossSellingElementCollection([$group1, $group2, $group3]));
        $this->groupProvider->method('getLookup')->willReturn($lookup);

        // Selectors: first proposes position 3 (valid), second should not be consulted
        $selector1 = $this->selectorReturning(3);
        $selector2 = $this->selectorReturning(2);

        $sut = new CrossSellSelectionService(
            $this->productProvider,
            $this->groupProvider,
            [$selector1, $selector2],
        );

        $picked = $sut->pick($productId, $this->context);

        self::assertInstanceOf(CrossSellingElement::class, $picked);
        self::assertSame(3, $picked->getCrossSelling()->getPosition());
    }

    public function testRespectsSelectorOrderAndPicksFirstNonEmptyMatch(): void
    {
        $ctx     = $this->createStub(SalesChannelContext::class);
        $product = $this->createStub(ProductEntity::class);

        $productProvider = $this->createStub(ProductProviderInterface::class);
        $productProvider->method('get')->willReturn($product);

        $pos1Empty     = $this->makeElement(1, 0);
        $pos2NonEmpty  = $this->makeElement(2, 2);
        $lookup        = CrossSellLookup::fromCollection(new CrossSellingElementCollection([$pos1Empty, $pos2NonEmpty]));

        $groupProvider = $this->createStub(CrossSellGroupProviderInterface::class);
        $groupProvider->method('getLookup')->willReturn($lookup);

        // First selector -> empty position 1; second -> non-empty position 2
        $selector1 = $this->selectorReturning(1);
        $selector2 = $this->selectorReturning(2);

        $service = new CrossSellSelectionService($productProvider, $groupProvider, [$selector1, $selector2]);

        self::assertSame($pos2NonEmpty, $service->pick('pid', $ctx));
    }

    public function testReturnsFirstNonEmptyWhenNoSelectorMatches(): void
    {
        $productId = 'dummy-product-id';

        $product = new ProductEntity();
        $product->setId($productId);
        $this->productProvider->method('get')->willReturn($product);

        // 1 = empty, 2 = empty, 3 = first non-empty (fallback)
        $group1 = $this->makeElement(1, 0);
        $group2 = $this->makeElement(2, 0);
        $group3 = $this->makeElement(3, 5);

        $lookup = CrossSellLookup::fromCollection(new CrossSellingElementCollection([$group1, $group2, $group3]));
        $this->groupProvider->method('getLookup')->willReturn($lookup);

        // Selectors don't produce a valid non-empty group: 1 (empty), 99 (missing), null (skip)
        $selector1 = $this->selectorReturning(1);
        $selector2 = $this->selectorReturning(99);
        $selector3 = $this->selectorReturning(null);

        $sut = new CrossSellSelectionService(
            $this->productProvider,
            $this->groupProvider,
            [$selector1, $selector2, $selector3],
        );

        $picked = $sut->pick($productId, $this->context);

        self::assertInstanceOf(CrossSellingElement::class, $picked);
        self::assertSame(
            3,
            $picked->getCrossSelling()->getPosition(),
            'Should fall back to the first non-empty group',
        );
    }

    private function selectorReturning(?int $position): PositionSelectorInterface
    {
        $stub = $this->createStub(PositionSelectorInterface::class);
        $stub->method('select')->willReturn($position);
        return $stub;
    }
}
