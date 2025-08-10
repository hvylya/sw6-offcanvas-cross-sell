<?php

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__ . '/src', __DIR__ . '/tests'])
    ->name('*.php')
    ->exclude(['vendor', 'var']);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PER-CS2.0' => true,
        '@PSR12' => true,
        'no_unused_imports' => true,
        'ordered_imports' => ['sort_algorithm' => 'alpha', 'imports_order' => ['class', 'function', 'const']],
        'declare_strict_types' => true,
        'native_function_invocation' => ['include' => ['@compiler_optimized'], 'scope' => 'namespaced'],
        'phpdoc_order' => true,
        'phpdoc_align' => ['align' => 'left'],
    ])
    ->setFinder($finder);
