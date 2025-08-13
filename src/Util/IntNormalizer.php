<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Util;

final class IntNormalizer
{
    private function __construct() {}

    public static function toPositiveIntOrNull(mixed $input): ?int
    {
        if (!\is_scalar($input)) {
            return null;
        }

        $stringOrNumber = \is_string($input) ? trim($input) : $input;

        return filter_var(
            $stringOrNumber,
            \FILTER_VALIDATE_INT,
            [
                'flags' => \FILTER_NULL_ON_FAILURE,
                'options' => ['min_range' => 1],
            ],
        );
    }
}
