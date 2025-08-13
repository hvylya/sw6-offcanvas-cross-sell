<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Tests\Unit\CrossSell\Select;

use Hv\Offcanvas\CrossSell\Select\GlobalConfigPositionSelector;
use PHPUnit\Framework\TestCase;
use Shopware\Core\Content\Product\ProductEntity;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\System\SystemConfig\SystemConfigService;

final class GlobalConfigPositionSelectorTest extends TestCase
{
    private SalesChannelContext $context;

    protected function setUp(): void
    {
        $this->context  = $this->createStub(SalesChannelContext::class);
    }

    public function testReadsPositiveIntFromSystemConfig(): void
    {
        $selector = $this->stubCfg('4');
        self::assertSame(4, $selector->select(new ProductEntity(), $this->context));
    }

    public function testReturnsNullForZeroOrNull(): void
    {
        $selectorZero = $this->stubCfg('0');
        self::assertNull($selectorZero->select(new ProductEntity(), $this->context));

        $selectorNull = $this->stubCfg(null);
        self::assertNull($selectorNull->select(new ProductEntity(), $this->context));
    }

    private function stubCfg(mixed $value): GlobalConfigPositionSelector
    {
        $cfg = $this->createStub(SystemConfigService::class);
        $cfg->method('get')->willReturn($value);

        return new GlobalConfigPositionSelector($cfg);
    }
}
