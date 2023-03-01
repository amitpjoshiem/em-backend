<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Init Container
    |--------------------------------------------------------------------------
    |
    |
    |
    */

    'group' => [
        'Financial',
        'Operational',
        'Governance',
        'Valuation',
    ],

    'type' => [
        'Qualitative',
        'Valuation',
    ],

    'valuation_scope' => [
        'max' => 200,
        'min' => -66,
    ],

    'valuation_max'     => 'excellent',
    'valuation_initial' => 'good',
    'valuation_min'     => 'v_poor',

    'score_mapper' => [
        'excellent' => 'Excellent',
        'v_good'    => 'V. Good',
        'good'      => 'Good',
        'average'   => 'Average',
        'below_ave' => 'Below Ave.',
        'poor'      => 'Poor',
        'v_poor'    => 'V. Poor',
        'n_a'       => 'n/a.',
    ],

    'score' => [
        'excellent' => 3,
        'v_good'    => 2,
        'good'      => 1,
        'average'   => 0,
        'below_ave' => -1,
        'poor'      => -2,
        'v_poor'    => -3,
        'n_a'       => null,
    ],

    'valuation' => [
        'excellent' => 200,
        'v_good'    => 100,
        'good'      => 50,
        'average'   => 25,
        'below_ave' => -20,
        'poor'      => -33,
        'v_poor'    => -50,
        'n_a'       => null,
    ],

    'relevance_mapper' => [
        'moderate' => 'Moderate',
        'high'     => 'High',
        'low'      => 'Low',
        'n_a'      => 'n/a',
    ],

    'relevance' => [
        'moderate' => 3,
        'high'     => 2,
        'low'      => 1,
        'n_a'      => 0,
    ],

    'data_sources' => [
        'user'       => 'UserUploaded',
        'api_first'  => 'Bloomberg',
        'api_second' => 'Morningstar',
    ],
];
