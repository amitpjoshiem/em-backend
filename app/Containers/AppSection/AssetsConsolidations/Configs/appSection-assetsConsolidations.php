<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | AppSection Section AssetsConsolidations Container
    |--------------------------------------------------------------------------
    |
    |
    |
    */
    'min_assets_consolidations' => 5,
    'table_rows'                => 21,
    'export'                    => [
        'excel' => [
            'table_rows'       => 21,
            'tables_name_cell' => [
                'A3',
                'A29',
                'A55',
                'A75',
                'A101',
                'A127',
                'A147',
                'A173',
                'A199',
                'A255',
            ],
            'columns_alias' => [
                'name'                  => 'A',
                'amount'                => 'C',
                'management_expense'    => 'D',
                'turnover'              => 'E',
                'trading_cost'          => 'F',
                'wrap_fee'              => 'G',
            ],
            'table_header'  => [
                'A'     => 'Name',
                'B'     => '% of Holdings',
                'C'     => 'Amount',
                'D'     => 'Management Expense',
                'E'     => 'Turnover %',
                'F'     => 'Trading Costs*',
                'G'     => 'Wrap Fee',
                'H'     => 'Total Cost in %',
                'I'     => '',
            ],
            'footer_text' => [
                '*Bid/Ask Spread Costs vary from fund to fund and are determined by the turnover percentage of each; 1% is thought to represent a conservative estimate of those costs.',
                'Figures are estimates, only.',
            ],
        ],
    ],
    'assets_accounts_doc_front_url' => '/advisor/document-export/%s/%s',
];
