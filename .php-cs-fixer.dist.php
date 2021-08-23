<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude([
        'app',
        'backups',
        'bin',
        'doc',
        'gulp_mappings',
        'node_modules',
        'symfony4/assets',
        'symfony4/bin',
        'symfony4/codeCoverage',
        'symfony4/config',
        'symfony4/node_modules',
        'symfony4/public',
        'symfony4/var',
        'symfony4/vendor',
        'vendor',
        'web',
        ])
    ->in(__DIR__);

$config = new PhpCsFixer\Config();
return $config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR1' => true,
        '@PSR2' => true,
        'align_multiline_comment' => true,
        'array_syntax' => ['syntax' => 'short'],
        'blank_line_after_namespace' => true,
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement' => ['statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try', 'switch']],
        'cast_spaces' => ['space' => 'none'],
        'combine_consecutive_issets' => true,
        'combine_consecutive_unsets' => true,
        'concat_space' => ['spacing' => 'one'],
        'declare_equal_normalize' => ['space' => 'single'],
        'declare_strict_types' => true,
        'elseif' => true,
        'linebreak_after_opening_tag' => true,
        'lowercase_cast' => true,
        'constant_case' => ['case' => 'lower'],
        'lowercase_keywords' => true,
        'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline'],
        'class_attributes_separation' => [
            'elements' => [
                'const' => 'none',
                'method' => 'one',
                'property' => 'none'
            ]
        ],
        'new_with_braces' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_blank_lines_after_phpdoc' => true,
        'no_empty_comment' => true,
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'no_multiline_whitespace_around_double_arrow' => true,
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'no_short_bool_cast' => true,
        'echo_tag_syntax' => [
            'format' => 'long'
        ],
        'no_trailing_comma_in_singleline_array' => true,
        //risky 'no_unneeded_final_method' => true,
        'no_unused_imports' => true,
        'no_useless_else' => true,
        'normalize_index_brace' => true,
        'not_operator_with_successor_space' => false,
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'php_unit_fqcn_annotation' => true,
        'phpdoc_add_missing_param_annotation' => true,
        'phpdoc_align' => true,
        'phpdoc_indent' => true,
        'phpdoc_order' => true,
        'phpdoc_separation' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_to_comment' => true,
        'phpdoc_trim' => true,
        'phpdoc_types' => true,
        'phpdoc_var_without_name' => true,
        //'self_accessor' => true,
        'short_scalar_cast' => true,
        'single_import_per_statement' => false,
        'single_blank_line_before_namespace' => true,
        //'single_line_comment_style' => true,
        'single_quote' => true,
        'standardize_not_equals' => true,
        'ternary_operator_spaces' => true,
        'trailing_comma_in_multiline' => [
            'after_heredoc' => false,
            'elements' => ['arrays']
        ],
        'trim_array_spaces' => true,
        'unary_operator_spaces' => true
    ])
    ->setFinder($finder);
