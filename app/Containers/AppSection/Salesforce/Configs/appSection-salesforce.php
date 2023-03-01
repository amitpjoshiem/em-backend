<?php

declare(strict_types=1);

use App\Containers\AppSection\Salesforce\Data\Enums\OpportunityStageEnum;

return [

    /*
    |--------------------------------------------------------------------------
    | AppSection Section Salesforce Container
    |--------------------------------------------------------------------------
    |
    |
    |
    */
    'login_url'                 => env('SALESFORCE_LOGIN_URL'),
    'username'                  => env('SALESFORCE_USERNAME'),
    'password'                  => env('SALESFORCE_PASSWORD'),
    'secretToken'               => env('SALESFORCE_SECRET_TOKEN'),
    'clientId'                  => env('SALESFORCE_CLIENT_ID'),
    'clientSecret'              => env('SALESFORCE_CLIENT_SECRET'),
    'api_version'               => '52.0',
    'app_url'                   => env('SALESFORCE_APP_URL'),
    'token_ttl'                 => 3600,
    'salesforce_front_path'     => '/settings-app/partners',
    'campaign_id'               => '7011M000000GuQpQAK',
    'opportunity_stage_schema'  => [
        OpportunityStageEnum::APPOINTMENT_1ST => [
            'date_of_1st' => [
                'name'     => 'date_of_1st',
                'label'    => 'Date of First Appt',
                'type'     => 'date',
                'rules'    => [
                    'required' => true,
                    'message'  => 'Please choose Date',
                ],
            ],
        ],
        OpportunityStageEnum::APPOINTMENT_2ND => [
            'date_of_2nd' => [
                'name'     => 'date_of_2nd',
                'label'    => 'Date of Second Appt',
                'type'     => 'date',
                'rules'    => [
                    'required' => true,
                    'message'  => 'Please choose Date',
                ],
            ],
            'result_1st_appt' => [
                'name'     => 'result_1st_appt',
                'label'    => 'Result of First Appt',
                'type'     => 'select',
                'options'  => [
                    [
                        'value' => 'Client Not Interested',
                        'label' => 'Client Not Interested',
                    ],
                    [
                        'value' => 'SWD Not Interested',
                        'label' => 'SWD Not Interested',
                    ],
                    [
                        'value' => 'Set 2nd Appt',
                        'label' => 'Set 2nd Appt',
                    ],
                    [
                        'value' => 'Became Client',
                        'label' => 'Became Client',
                    ],
                    [
                        'value' => 'Cancel',
                        'label' => 'Cancel',
                    ],
                    [
                        'value' => 'No Show',
                        'label' => 'No Show',
                    ],
                ],
                'rules' => [
                    'required' => true,
                    'message'  => 'Please select Result',
                ],
            ],
            'status_1st_appt' => [
                'name'     => 'status_1st_appt',
                'label'    => 'Status of First Appt',
                'type'     => 'select',
                'options'  => [
                    [
                        'value' => 'Kept Original',
                        'label' => 'Kept Original',
                    ],
                    [
                        'value' => 'Dropped',
                        'label' => 'Dropped',
                    ],
                    [
                        'value' => 'Rescheduled - Kept',
                        'label' => 'Rescheduled - Kept',
                    ],
                    [
                        'value' => 'Rescheduled - Dropped',
                        'label' => 'Rescheduled - Dropped',
                    ],
                ],
                'rules' => [
                    'required' => true,
                    'message'  => 'Please select Status',
                ],
            ],
        ],
        OpportunityStageEnum::APPOINTMENT_3RD => [
            'date_of_3rd' => [
                'name'     => 'date_of_3rd',
                'label'    => 'Date of Third Appt',
                'type'     => 'date',
                'rules'    => [
                    'required' => true,
                    'message'  => 'Please choose Date',
                ],
            ],
            'result_2nd_appt' => [
                'name'     => 'result_2nd_appt',
                'label'    => 'Result of Second Appt',
                'type'     => 'select',
                'options'  => [
                    [
                        'value' => 'Client Not Interested',
                        'label' => 'Client Not Interested',
                    ],
                    [
                        'value' => 'SWD Not Interested',
                        'label' => 'SWD Not Interested',
                    ],
                    [
                        'value' => 'Set a Third Appointment',
                        'label' => 'Set a Third Appointment',
                    ],
                    [
                        'value' => 'Became Client',
                        'label' => 'Became Client',
                    ],
                    [
                        'value' => 'Cancel',
                        'label' => 'Cancel',
                    ],
                    [
                        'value' => 'No Show',
                        'label' => 'No Show',
                    ],
                ],
                'rules' => [
                    'required' => true,
                    'message'  => 'Please select Result',
                ],
            ],
            'status_2nd_appt' => [
                'name'     => 'status_2nd_appt',
                'label'    => 'Status of Second Appt',
                'type'     => 'select',
                'options'  => [
                    [
                        'value' => 'Kept Original',
                        'label' => 'Kept Original',
                    ],
                    [
                        'value' => 'Dropped',
                        'label' => 'Dropped',
                    ],
                    [
                        'value' => 'Rescheduled - Kept',
                        'label' => 'Rescheduled - Kept',
                    ],
                    [
                        'value' => 'Rescheduled - Dropped',
                        'label' => 'Rescheduled - Dropped',
                    ],
                ],
                'rules' => [
                    'required' => true,
                    'message'  => 'Please select Status',
                ],
            ],
        ],
        OpportunityStageEnum::CLOSED => [
            'closed_status' => [
                'name'     => 'closed_status',
                'label'    => 'Closed Status',
                'type'     => 'select',
                'options'  => [
                    [
                        'value' => OpportunityStageEnum::CLOSED_WON,
                        'label' => OpportunityStageEnum::getTitle(OpportunityStageEnum::CLOSED_WON),
                    ],
                    [
                        'value' => OpportunityStageEnum::CLOSED_LOST,
                        'label' => OpportunityStageEnum::getTitle(OpportunityStageEnum::CLOSED_LOST),
                    ],
                ],
                'rules' => [
                    'required' => true,
                    'message'  => 'Please select Closed Status',
                ],
            ],
        ],
    ],
];
