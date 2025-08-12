<?php

declare(strict_types=1);

namespace Hv\Offcanvas\CrossSell\Select;

use Hv\Offcanvas\CrossSell\Group\CrossSellGroupProviderInterface;
use Hv\Offcanvas\CrossSell\Product\ProductProviderInterface;
use Shopware\Core\Content\Product\SalesChannel\CrossSelling\CrossSellingElement;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

final readonly class CrossSellSelectionService
{
    /**
     * @param iterable<PositionSelectorInterface> $selectors
     */
    public function __construct(
        private ProductProviderInterface $productProvider,
        private CrossSellGroupProviderInterface $groupProvider,
        private iterable $selectors,
    ) {}

    public function pick(string $productId, SalesChannelContext $context): ?CrossSellingElement
    {
        $product = $this->productProvider->get($productId, $context);
        if ($product === null) {
            return null;
        }

        $crossSellLookup = $this->groupProvider->getLookup($productId, $context);
        if ($crossSellLookup->count() === 0) {
            return null;
        }

        foreach ($this->selectors as $selector) {
            $preferredPosition = $selector->select($product, $context);
            if ($preferredPosition !== null) {
                $selectedElement = $crossSellLookup->getByPosition($preferredPosition);
                if ($selectedElement !== null) {
                    return $selectedElement;
                }
            }
        }

        return $crossSellLookup->getFirstNonEmpty();
    }
}
