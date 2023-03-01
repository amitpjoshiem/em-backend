<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Media Container
    |--------------------------------------------------------------------------
    |
    |
    |
    */

    /**
     * Types of allowed media.
     */
    'allowed-media-types'         => [
        'image',
        'document',
    ],

    /**
     * Regenerate uploaded media after assign to model. Default state is false.
     */
    'regenerate-after-assigning' => false,

    /**
     * Enable/Disable temporary_uploads table autovacuum command.
     */
    'enabled-schedule-temporary-clean' => env('SCHEDULE_MEDIA_TEMPORARY_CLEAN', false),

    'documents-mime-types' => [
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // .doc & .docx
        'application/vnd.ms-powerpoint',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation', // .ppt & .pptx
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // .xls & .xlsx
        'text/plain',
        'application/pdf',
        'application/zip',
        'application/x-rar',
        'application/x-rar-compressed',
        'application/octet-stream',
    ],

    'collection_types' => [
        'investment_and_retirement_accounts' => [
            'pdf',
            'jpeg',
            'jpg',
            'png',
            'doc',
            'docx',
            'xls',
            'xlsx',
        ],
        'life_insurance_annuity_and_long_terms_care_policies' => [
            'pdf',
            'jpeg',
            'jpg',
            'png',
            'doc',
            'docx',
            'xls',
            'xlsx',
        ],
        'social_security_information' => [
            'pdf',
            'jpeg',
            'jpg',
            'png',
            'doc',
            'docx',
            'xls',
            'xlsx',
        ],
        'medicare_details' => [
            'pdf',
            'jpeg',
            'jpg',
            'png',
            'doc',
            'docx',
            'xls',
            'xlsx',
        ],
        'property_casualty' => [
            'pdf',
            'jpeg',
            'jpg',
            'png',
            'doc',
            'docx',
            'xls',
            'xlsx',
        ],
    ],
    /** file size in Kb */
    'collection_size' => [
        'investment_and_retirement_accounts'                  => 20480,
        'life_insurance_annuity_and_long_terms_care_policies' => 20480,
        'social_security_information'                         => 20480,
        'medicare_details'                                    => 20480,
        'property_casualty'                                   => 20480,
    ],
];
