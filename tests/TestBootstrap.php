<?php

declare(strict_types=1);

use Shopware\Core\TestBootstrapper;

$projectDir = dirname(__DIR__, 4);
require $projectDir . '/vendor/autoload.php';

(new TestBootstrapper())
    ->setProjectDir($projectDir)
    ->setLoadEnvFile(true)
    ->addCallingPlugin()
    ->bootstrap();
