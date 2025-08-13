<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Install\CustomField;

use Hv\Offcanvas\CrossSell\CrossSellKeys;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\CustomField\Aggregate\CustomFieldSet\CustomFieldSetCollection;
use Shopware\Core\System\CustomField\CustomFieldTypes;

final readonly class ProductCrossSellIndexInstaller
{
    private const SET_NAME = 'hv_offcanvas';

    private const RELATION_ENTITY = 'product';

    /** @param EntityRepository<CustomFieldSetCollection> $customFieldSetRepository */
    public function __construct(
        private EntityRepository $customFieldSetRepository,
    ) {}

    public function install(Context $context): void
    {
        $this->customFieldSetRepository->upsert([
            [
                'id' => self::setId(),
                'name' => self::SET_NAME,
                'config' => [
                    'label' => [
                        'en-GB' => 'Offcanvas Cross-Sell (minimal cart)',
                        'de-DE' => 'Offcanvas Cross-Selling (Mini-Warenkorb)',
                        Defaults::LANGUAGE_SYSTEM => 'Offcanvas Cross-Sell (minimal cart)',
                    ],
                ],

                'relations' => [
                    [
                        'id' => self::relationId(),
                        'entityName' => self::RELATION_ENTITY,
                    ],
                ],

                'customFields' => [
                    [
                        'id' => self::fieldId(),
                        'name' => CrossSellKeys::PRODUCT_CROSS_SELL_POSITION,
                        'type' => CustomFieldTypes::INT,
                        'active' => true,
                        'config' => [
                            'label' => [
                                'en-GB' => 'Cross-sell group position',
                                'de-DE' => 'Position der Cross-Selling-Gruppe',
                                Defaults::LANGUAGE_SYSTEM => 'Cross-sell group position',
                            ],
                            'helpText' => [
                                'en-GB' => 'Which cross-sell group to show in the mini cart. Leave empty or enter 0 to use the shop default. 1 is the first group, 2 the second.',
                                'de-DE' => 'Welche Cross-Selling-Gruppe im Mini-Warenkorb angezeigt wird. Leer lassen oder 0 eingeben, um die Shop-Voreinstellung zu verwenden. 1 = erste Gruppe, 2 = zweite.',
                                Defaults::LANGUAGE_SYSTEM => 'Which cross-sell group to show in the mini cart. Leave empty or enter 0 to use the shop default. 1 is the first group, 2 the second.',
                            ],
                            'placeholder' => [
                                'en-GB' => 'e.g. 3... — overrides global',
                                'de-DE' => 'z. B. 3... — überschreibt global',
                                Defaults::LANGUAGE_SYSTEM => 'e.g. 3... — overrides global',
                            ],
                            'min' => 0,
                            'customFieldPosition' => 1,
                        ],
                    ],
                ],
            ],
        ], $context);
    }

    public function uninstall(Context $context): void
    {
        $this->customFieldSetRepository->delete([['id' => self::setId()]], $context);
    }

    private static function setId(): string
    {
        return Uuid::fromStringToHex('hv_offcanvas:set');
    }

    private static function relationId(): string
    {
        return Uuid::fromStringToHex('hv_offcanvas:relation:product');
    }

    private static function fieldId(): string
    {
        return Uuid::fromStringToHex('hv_offcanvas:field:cross_sell_index');
    }
}
