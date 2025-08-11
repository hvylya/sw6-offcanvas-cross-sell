<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Cart;

final readonly class AddToCartIntent
{
    public function __construct(private ?string $lastReferencedId) {}

    public function lastReferencedId(): ?string
    {
        return $this->lastReferencedId;
    }
}
