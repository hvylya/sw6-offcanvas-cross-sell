<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Tests\Unit\Cart;

use Hv\Offcanvas\Cart\AddToCartIntentExtractor;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;

#[CoversClass(AddToCartIntentExtractor::class)]
final class AddToCartIntentExtractorTest extends TestCase
{
    private AddToCartIntentExtractor $extractor;

    protected function setUp(): void
    {
        $this->extractor = new AddToCartIntentExtractor();
    }

    public function testEmptyLineItemsReturnsNullId(): void
    {
        $bag = $this->bagFromIds();
        self::assertNull($this->extractor->fromDataBag($bag)->lastReferencedId());
    }

    public function testWhitespaceReferencedIdIsIgnored(): void
    {
        $bag = $this->bagFromIds('   ');
        self::assertNull($this->extractor->fromDataBag($bag)->lastReferencedId());
    }

    public function testSingleLineItemReturnsItsReferencedId(): void
    {
        $bag = $this->bagFromIds('product_1');
        self::assertSame('product_1', $this->extractor->fromDataBag($bag)->lastReferencedId());
    }

    public function testMultipleLineItemsReturnLastReferencedId(): void
    {
        $bag = $this->bagFromIds('product_1', 'product_2');
        self::assertSame('product_2', $this->extractor->fromDataBag($bag)->lastReferencedId());
    }

    public function testReturnsNullWhenLineItemsKeyMissing(): void
    {
        $bag = new RequestDataBag();
        self::assertNull($this->extractor->fromDataBag($bag)->lastReferencedId());
    }

    public function testReturnsNullWhenLineItemsIsNotCollection(): void
    {
        $bag = new RequestDataBag(['lineItems' => 'oops']);
        self::assertNull($this->extractor->fromDataBag($bag)->lastReferencedId());
    }

    /**
     * Build RequestDataBag similar to CartLineItemController payload.
     * Each ID becomes an item:
     *  - null => []
     *  - ''   => ['referencedId' => '']
     *  - 'x'  => ['referencedId' => 'x']
     */
    private function bagFromIds(?string ...$ids): RequestDataBag
    {
        $items = array_map(
            static fn (?string $id): array => $id === null ? [] : ['referencedId' => $id],
            $ids,
        );

        return new RequestDataBag([
            'lineItems' => new RequestDataBag($items),
        ]);
    }
}
