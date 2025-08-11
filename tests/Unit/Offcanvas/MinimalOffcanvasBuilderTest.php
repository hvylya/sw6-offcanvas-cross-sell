<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Tests\Unit\Offcanvas;

use Hv\Offcanvas\Cart\AddToCartIntent;
use Hv\Offcanvas\Cart\AddToCartIntentExtractorInterface;
use Hv\Offcanvas\Cart\LastAddedLineItemFinderInterface;
use Hv\Offcanvas\Offcanvas\MinimalOffcanvasBuilder;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Checkout\Cart\Cart;
use Shopware\Core\Checkout\Cart\LineItem\LineItem;
use Shopware\Core\Checkout\Cart\SalesChannel\CartService;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

#[CoversClass(MinimalOffcanvasBuilder::class)]
final class MinimalOffcanvasBuilderTest extends TestCase
{
    private const TOKEN = 'test-token';

    private CartService $cartService;
    private AddToCartIntentExtractorInterface $extractor;
    private LastAddedLineItemFinderInterface $finder;

    protected function setUp(): void
    {
        $this->cartService = $this->createMock(CartService::class);
        $this->extractor = $this->createMock(AddToCartIntentExtractorInterface::class);
        $this->finder = $this->createMock(LastAddedLineItemFinderInterface::class);
    }

    public function testReturnsNullWhenIntentHasNoReferencedId(): void
    {
        $bag = new RequestDataBag();
        $context = $this->createContext(self::TOKEN);
        $cart = new Cart(self::TOKEN);

        $this->cartService
            ->expects(self::once())
            ->method('getCart')
            ->with(self::TOKEN, $context)
            ->willReturn($cart);

        $this->extractor
            ->expects(self::once())
            ->method('fromDataBag')
            ->with(self::identicalTo($bag))
            ->willReturn(new AddToCartIntent(null));

        $this->finder
            ->expects(self::once())
            ->method('find')
            ->with(
                self::callback(fn (AddToCartIntent $i) => $i->lastReferencedId() === null),
                self::identicalTo($cart),
            )
            ->willReturn(null);

        $builder = $this->createBuilder();
        $view = $builder->build($bag, $context);

        self::assertNull($view);
    }

    public function testReturnsNullWhenFinderDoesNotFindItem(): void
    {
        $context = $this->createContext(self::TOKEN);
        $cart = new Cart(self::TOKEN);
        $bag = $this->createRequestBag([['referencedId' => 'product_1']]);

        $this->cartService
            ->expects(self::once())
            ->method('getCart')
            ->with(self::TOKEN, $context)
            ->willReturn($cart);

        $this->extractor
            ->expects(self::once())
            ->method('fromDataBag')
            ->with(self::identicalTo($bag))
            ->willReturn(new AddToCartIntent('product_1'));

        $this->finder
            ->expects(self::once())
            ->method('find')
            ->with(self::isInstanceOf(AddToCartIntent::class), $cart)
            ->willReturn(null);

        $builder = $this->createBuilder();
        $view = $builder->build($bag, $context);

        self::assertNull($view);
    }

    public function testFoundItemReturnsViewWithSameCartAndItem(): void
    {
        $context = $this->createContext(self::TOKEN);
        $cart = new Cart(self::TOKEN);
        $bag = $this->createRequestBag([['referencedId' => 'product_1']]);
        $item = new LineItem('li_product_product_1_1', LineItem::PRODUCT_LINE_ITEM_TYPE, 'product_1');

        $this->cartService
            ->expects(self::once())
            ->method('getCart')
            ->with(self::TOKEN, $context)
            ->willReturn($cart);

        $this->extractor
            ->expects(self::once())
            ->method('fromDataBag')
            ->with(self::identicalTo($bag))
            ->willReturn(new AddToCartIntent('product_1'));

        $this->finder
            ->expects(self::once())
            ->method('find')
            ->with(self::isInstanceOf(AddToCartIntent::class), $cart)
            ->willReturn($item);

        $builder = $this->createBuilder();
        $view = $builder->build($bag, $context);

        self::assertNotNull($view);
        self::assertSame($item, $view->lastAdded);
        self::assertSame($cart, $view->cart);
    }

    /* helpers */

    private function createRequestBag(array $lineItems): RequestDataBag
    {
        return new RequestDataBag([
            'lineItems' => new RequestDataBag($lineItems),
        ]);
    }

    private function createContext(string $token): SalesChannelContext
    {
        $context = $this->createMock(SalesChannelContext::class);
        $context->method('getToken')->willReturn($token);

        return $context;
    }

    private function createBuilder(): MinimalOffcanvasBuilder
    {
        return new MinimalOffcanvasBuilder($this->cartService, $this->extractor, $this->finder);
    }
}
