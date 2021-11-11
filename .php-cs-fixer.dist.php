<?php

declare(strict_types=1);

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude(['var', 'vendor']);

return (new PhpCsFixer\Config())
    ->setRules([
        'declare_strict_types' => true,
        '@PhpCsFixer' => true,
        'php_unit_test_class_requires_covers' => false,
        'php_unit_internal_class' => false,
        'array_syntax' => ['syntax' => 'short'],
        'array_indentation' => true,
        'no_superfluous_phpdoc_tags' => false,
        'ordered_imports' => true,
        'phpdoc_add_missing_param_annotation' => false,
        'phpdoc_order' => true,
        'phpdoc_to_comment' => false,
        'single_line_throw' => false,
        'return_assignment' => false,
        'php_unit_method_casing' => ['case' => 'snake_case'],
        'blank_line_before_statement' => [
            'statements' => [
                'break',
                'continue',
                'declare',
                'return',
                'throw',
                'try',
                'if',
            ],
        ],
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
                'constant_public',
                'constant_protected',
                'constant_private',
                'property_public',
                'property_protected',
                'property_private',
                'construct',
                'destruct',
                'magic',
                'phpunit',
            ],
        ],
        'multiline_whitespace_before_semicolons' => true,
        'phpdoc_annotation_without_dot' => true,
        'no_unused_imports' => true,
    ])
    ->setRiskyAllowed(true)
    ->setLineEnding("\n")
    ->setFinder($finder);
