<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Tests\Unit\Cart;

use Hv\Offcanvas\Cart\AddToCartIntent;
use Hv\Offcanvas\Cart\LastAddedLineItemFinder;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Checkout\Cart\Cart;
use Shopware\Core\Checkout\Cart\LineItem\LineItem;

#[CoversClass(LastAddedLineItemFinder::class)]
final class LastAddedLineItemFinderTest extends TestCase
{
    private LastAddedLineItemFinder $finder;

    protected function setUp(): void
    {
        $this->finder = new LastAddedLineItemFinder();
    }

    public function testReturnsNullWhenIntentHasNoReferencedId(): void
    {
        $cart = $this->createCart($this->createProductItem('product_red'));

        self::assertNull($this->finder->find(new AddToCartIntent(null), $cart));
    }

    public function testReturnsNullWhenIdNotInCart(): void
    {
        $cart = $this->createCart(
            $this->createProductItem('product_red'),
            $this->createProductItem('product_blue'),
        );

        $intent = new AddToCartIntent('product_green');

        self::assertNull($this->finder->find($intent, $cart));
    }

    public function testIgnoresNonProductItemsEvenIfIdMatches(): void
    {
        $nonProduct = new LineItem(
            'li_custom_product_blue_1',
            LineItem::CUSTOM_LINE_ITEM_TYPE,
            'product_blue',
        );

        $cart = $this->createCart(
            $nonProduct,
            $this->createProductItem('product_red'),
        );

        $intent = new AddToCartIntent('product_blue');

        self::assertNull($this->finder->find($intent, $cart));
    }

    public function testReturnsMatchingProductLineItem(): void
    {
        $target = $this->createProductItem('product_blue');

        $cart = $this->createCart(
            $this->createProductItem('product_red'),
            $target,
            $this->createProductItem('product_green'),
        );

        $intent = new AddToCartIntent('product_blue');

        self::assertSame($target, $this->finder->find($intent, $cart));
    }

    private function createCart(LineItem ...$items): Cart
    {
        $cart = new Cart('some-token');
        foreach ($items as $i) {
            $cart->add($i);
        }

        return $cart;
    }

    private function createProductItem(string $referencedId, int $quantity = 1): LineItem
    {
        return new LineItem(
            'li_product_' . $referencedId . '_' . $quantity,
            LineItem::PRODUCT_LINE_ITEM_TYPE,
            $referencedId,
            $quantity,
        );
    }
}
