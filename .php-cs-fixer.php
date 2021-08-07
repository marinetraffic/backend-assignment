<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->path([
        'app',
        'config',
        'database',
        'routes',
        'tests',
    ])
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
;

$config = new PhpCsFixer\Config();
$config->setRiskyAllowed(true);
return $config->setRules([
    '@PSR12' => true,
    '@Symfony'                        => true,
    '@PHP74Migration'                 => true,
    'strict_param'                    => true,
    'array_syntax'                    => ['syntax' => 'short'],
    'class_attributes_separation'     => ['elements' => ['method']],
    'no_superfluous_phpdoc_tags'      => false,
    'compact_nullable_typehint'       => true,
    'no_null_property_initialization' => true,
    'no_superfluous_elseif'           => true,
    'no_useless_else'                 => true,
    'ordered_class_elements'          => true,
    'simplified_null_return'          => true,
    'yoda_style'                      => false,
    'php_unit_method_casing'          => 'camel_case',
    'binary_operator_spaces'          => [
        'operators' => [
            '='  => 'align_single_space_minimal',
            '=>' => 'align_single_space_minimal',
        ],
    ],
])
    ->setFinder($finder)
    ;
