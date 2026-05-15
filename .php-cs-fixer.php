<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests');

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PER-CS'                     => true,
        '@PHP82Migration:risky'       => true,
        'declare_strict_types'        => true,
        'strict_param'                => true,
        'no_unused_imports'           => true,
        'ordered_imports'             => ['sort_algorithm' => 'alpha'],
        'ordered_class_elements'      => true,
        'final_class'                 => true,
        'self_accessor'               => true,
        'no_superfluous_phpdoc_tags'  => true,
        'void_return'                 => true,
        'native_function_invocation'  => ['include' => ['@all']],
    ])
    ->setFinder($finder);
