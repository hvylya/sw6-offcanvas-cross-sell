<?php

declare(strict_types=1);

namespace Hv\Offcanvas\CrossSell\Group;

use Shopware\Core\Content\Product\SalesChannel\CrossSelling\CrossSellingElement;
use Shopware\Core\Content\Product\SalesChannel\CrossSelling\CrossSellingElementCollection;

final readonly class CrossSellLookup
{
    /** @param array<int, CrossSellingElement> $byPosition */
    private function __construct(
        private ?CrossSellingElement $firstNonEmpty,
        private array $byPosition,
        private int $totalCount,
    ) {}

    public static function fromCollection(CrossSellingElementCollection $elements): self
    {
        $byPosition = [];
        $firstNonEmpty = null;

        foreach ($elements as $element) {
            $pos = $element->getCrossSelling()->getPosition();
            if ($pos > 0 && !isset($byPosition[$pos])) {
                $byPosition[$pos] = $element;
            }
            if ($firstNonEmpty === null && $element->getProducts()->count() > 0) {
                $firstNonEmpty = $element;
            }
        }

        return new self($firstNonEmpty, $byPosition, $elements->count());
    }

    public function getByPosition(int $position): ?CrossSellingElement
    {
        $element = $this->byPosition[$position] ?? null;
        return ($element && $element->getProducts()->count() > 0) ? $element : null;
    }

    public function getFirstNonEmpty(): ?CrossSellingElement
    {
        return $this->firstNonEmpty;
    }

    public function count(): int
    {
        return $this->totalCount;
    }
}
