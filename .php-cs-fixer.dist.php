<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src');

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,
        'class_attributes_separation' => [
            'elements' => [
                'const' => 'one',
                'property' => 'one',
                'method' => 'one',
            ],
        ],
        'method_argument_space' => [
            'on_multiline' => 'ignore',
        ],
        'modifier_keywords' => false,
        'no_unused_imports' => true,
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
        ],
        'strict_param' => true,
        'binary_operator_spaces' => [
            'default' => 'single_space',
        ],
        'no_useless_else' => true,
        'no_useless_return' => true,
        'no_superfluous_phpdoc_tags' => true,
        'ordered_types' => [
            'null_adjustment' => 'always_last',
        ],
        'no_useless_nullsafe_operator' => true,
        'declare_strict_types' => true,
        'no_empty_statement' => true,
    ])
    ->setFinder($finder);
