<?php

declare(strict_types=1);

namespace Hv\Offcanvas\Offcanvas;

use Shopware\Core\Framework\Validation\DataBag\RequestDataBag;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

interface MinimalOffcanvasBuilderInterface
{
    public function build(RequestDataBag $requestDataBag, SalesChannelContext $context): ?MinimalOffcanvasView;
}
