<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Tests\Unit\CrossSell;

use Hv\Offcanvas\CrossSell\Group\CrossSellLookup;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Content\Product\SalesChannel\CrossSelling\CrossSellingElementCollection;

#[CoversClass(CrossSellLookup::class)]
final class CrossSellLookupTest extends TestCase
{
    use CrossSellFixturesTrait;

    public function testBuildsIndexAndPicksFirstNonEmpty(): void
    {
        $pos2FirstNonEmpty = $this->makeElement(2, 1);
        $pos1Empty = $this->makeElement(1, 0);
        $pos2Duplicate = $this->makeElement(2, 3);

        $collection = new CrossSellingElementCollection([$pos2FirstNonEmpty, $pos1Empty, $pos2Duplicate]);
        $lookup = CrossSellLookup::fromCollection($collection);

        self::assertSame(
            3,
            $lookup->count(),
            'count() returns the size of the underlying collection',
        );

        self::assertSame(
            $pos2FirstNonEmpty,
            $lookup->getFirstNonEmpty(),
            'firstNonEmpty must be the first element with > 0 products',
        );

        self::assertNull(
            $lookup->getByPosition(1),
            'empty group by position should resolve to null',
        );

        self::assertSame(
            $pos2FirstNonEmpty,
            $lookup->getByPosition(2),
            'on duplicate positions the FIRST element must win',
        );
    }

    public function testReturnsNullsWhenAllGroupsAreEmpty(): void
    {
        $collection = new CrossSellingElementCollection([
            $this->makeElement(1, 0),
            $this->makeElement(2, 0),
        ]);

        $lookup = CrossSellLookup::fromCollection($collection);

        self::assertNull(
            $lookup->getByPosition(1),
            'position=1 is empty -> null',
        );

        self::assertNull(
            $lookup->getByPosition(2),
            'position=2 is empty -> null',
        );

        self::assertNull(
            $lookup->getFirstNonEmpty(),
            'no non-empty groups -> firstNonEmpty should be null',
        );
    }
}
