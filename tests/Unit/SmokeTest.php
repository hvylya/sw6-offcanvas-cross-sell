<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Tests\Unit;

use PHPUnit\Framework\TestCase;

final class SmokeTest extends TestCase
{
    public function testPhpunitRuns(): void
    {
        $this->assertTrue(true); // @phpstan-ignore-line
    }
}
