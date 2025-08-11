<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Tests\Integration;

use PHPUnit\Framework\TestCase;
use Shopware\Core\Framework\Test\TestCaseBase\KernelTestBehaviour;

final class ContainerSmokeTest extends TestCase
{
    use KernelTestBehaviour;

    public function testContainerHasSystemConfig(): void
    {
        self::assertTrue(self::getContainer()->has('system_config.repository'));
    }
}
