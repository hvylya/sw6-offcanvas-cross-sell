<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Tests\Unit\Util;

use Hv\Offcanvas\Util\IntNormalizer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(IntNormalizerTest::class)]
final class IntNormalizerTest extends TestCase
{
    #[DataProvider('cases')]
    public function testToPositiveIntOrNull($input, ?int $expected): void
    {
        self::assertSame($expected, IntNormalizer::toPositiveIntOrNull($input));
    }

    public static function cases(): array
    {
        return [
            [null, null],
            ['  ', null],
            ['0', null],
            [0, null],
            [-5, null],
            [' 5 ', 5],
            ['2.0', null],
            ['abc', null],
            [new stdClass(), null],
        ];
    }
}
