<?php

declare(strict_types=1);

namespace Hv\Offcanvas;

use Hv\Offcanvas\Install\CustomField\ProductCrossSellIndexInstaller;
use Psr\Container\ContainerInterface;
use RuntimeException;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UninstallContext;
use Shopware\Core\Framework\Plugin\Context\UpdateContext;
use Shopware\Core\System\CustomField\Aggregate\CustomFieldSet\CustomFieldSetCollection;

class HvOffcanvasCrossSell extends Plugin
{
    public function install(InstallContext $installContext): void
    {
        $this->makeInstaller()->install($installContext->getContext());
        parent::install($installContext);
    }

    public function update(UpdateContext $updateContext): void
    {
        $this->makeInstaller()->install($updateContext->getContext());
        parent::update($updateContext);
    }

    public function uninstall(UninstallContext $uninstallContext): void
    {
        if (!$uninstallContext->keepUserData()) {
            $this->makeInstaller()->uninstall($uninstallContext->getContext());
        }
        parent::uninstall($uninstallContext);
    }

    private function makeInstaller(): ProductCrossSellIndexInstaller
    {
        $container = $this->requireContainer();

        /** @var EntityRepository<CustomFieldSetCollection> $repository */
        $repository = $container->get('custom_field_set.repository');

        return new ProductCrossSellIndexInstaller($repository);
    }

    private function requireContainer(): ContainerInterface
    {
        if (!$this->container instanceof ContainerInterface) {
            throw new RuntimeException('Container is not initialized yet.');
        }

        return $this->container;
    }
}
