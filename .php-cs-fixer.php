<?php

declare(strict_types=1);

namespace arkania;

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in('src/');

return (new Config())
    ->setRiskyAllowed(true)
    ->setRules([
        'native_function_invocation' => [
            'include' => [
                '@all'
            ],
            'scope'  => 'namespaced',
            'strict' => true,
        ],
        'no_empty_phpdoc'   => true,
        'no_unused_imports' => true,
        'ordered_imports'   => [
            'imports_order' => [
                'class',
                'function',
                'const',
            ],
            'sort_algorithm' => 'alpha',
        ],
        'phpdoc_align' => [
            'align' => 'vertical',
            'tags'  => [
                'param'
            ]
        ],
        'phpdoc_line_span' => [
            'property' => 'single',
            'method'   => null,
            'const'    => null,
        ],
        'phpdoc_trim'             => true,
        'modernize_strpos'        => true,
        'ordered_interfaces'      => true,
        'ordered_types'           => true,
        'elseif'                  => true,
        'include'                 => true,
        'simplified_if_return'    => true,
        'function_declaration'    => true,
        'return_type_declaration' => [
            'space_before' => 'one'
        ],
        'strict_param'            => true,
        'unary_operator_spaces'   => true,
        'align_multiline_comment' => [
            'comment_type' => 'phpdocs_only'
        ],
        'binary_operator_spaces' => [
            'operators' => [
                '=>' => 'align_single_space_minimal',
                '='  => 'align_single_space_minimal',
            ]
        ],
        'blank_line_after_namespace'   => true,
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement'  => [
            'statements' => [
                'declare'
            ]
        ],
        'fully_qualified_strict_types' => true,
        'concat_space'                 => [
            'spacing' => 'one'
        ],
        'declare_strict_types'       => true,
        'indentation_type'           => false,
        'logical_operators'          => true,
        'native_constant_invocation' => [
            'scope' => 'namespaced'
        ],
        'new_with_braces' => [
            'named_class'     => true,
            'anonymous_class' => false,
        ],
        'no_closing_tag'                                => true,
        'no_extra_blank_lines'                          => true,
        'no_trailing_whitespace'                        => true,
        'no_trailing_whitespace_in_comment'             => true,
        'no_whitespace_in_blank_line'                   => true,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        '@PSR2'                                         => true,
        'array_push'                                    => true,
        'array_syntax'                                  => ['syntax' => 'short'],
        'no_multiline_whitespace_around_double_arrow'   => true,
        'trim_array_spaces'                             => true,
        'whitespace_after_comma_in_array'               => ['ensure_single_space' => true],
        'no_multiple_statements_per_line'               => true,
        'no_trailing_comma_in_singleline'               => true,
        'single_line_empty_body'                        => false,
        'class_reference_name_casing'                   => true,
        'constant_case'                                 => ['case' => 'lower'],
        'integer_literal_case'                          => true,
        'lowercase_keywords'                            => true,
        'lowercase_static_reference'                    => true,
        'magic_constant_casing'                         => true,
        'magic_method_casing'                           => true,
        'native_function_casing'                        => true,
        'native_function_type_declaration_casing'       => true,
        'cast_spaces'                                   => true,
        'lowercase_cast'                                => true,
        'class_definition'                              => [
            'inline_constructor_arguments'        => false,
            'space_before_parenthesis'            => true,
            'multi_line_extends_each_single_line' => false,
            'single_item_single_line'             => true
        ],
        'final_internal_class'               => true,
        'no_blank_lines_after_class_opening' => true,
        'header_comment'                     => [
            'comment_type' => 'comment',
            'header'       => <<<BODY
 ____   __   __  _   _    ___    ____    ____    ___   _____  
/ ___|  \ \ / / | \ | |  / _ \  |  _ \  / ___|  |_ _| | ____| 
\___ \   \ V /  |  \| | | | | | | |_) | \___ \   | |  |  _|   
 ___) |   | |   | |\  | | |_| | |  __/   ___) |  | |  | |___  
|____/    |_|   |_| \_|  \___/  |_|     |____/  |___| |_____|

Nacre-UI est une API destiné aux formulaires,
elle permet aux développeurs d'avoir une compatibilité entre toutes les interfaces, 
mais aussi éviter les taches fastidieuses à faire.

@author SynopsieTeam
@link https://nacre.arkaniastudios.com/home.html
@version 2.0.0

BODY,
            'location' => 'after_open'

        ],
        'no_empty_comment'                        => true,
        'control_structure_braces'                => true,
        'control_structure_continuation_position' => true,
        'no_superfluous_elseif'                   => true,
        'no_useless_else'                         => true,
        'global_namespace_import'                 => [
            'import_classes'   => true,
            'import_constants' => true,
            'import_functions' => true
        ],
        'single_import_per_statement' => true,
        'single_line_after_imports'   => true,
        'combine_consecutive_unsets'  => true,
        'combine_consecutive_issets'  => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_superfluous_phpdoc_tags'  => true,
        'curly_braces_position'       => [
            'functions_opening_brace' => 'same_line',
            'classes_opening_brace'   => 'same_line'
        ]
    ])
    ->setFinder($finder)
    ->setIndent("\t")
    ->setLineEnding("\n");