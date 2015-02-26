<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */
    'users'  => [
        'model' => 'Maatwebsite\Usher\Domain\Users\User'
    ],

    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */
    'roles'  => [
        'model' => 'Maatwebsite\Usher\Domain\Roles\Role'
    ],

    /*
    |--------------------------------------------------------------------------
    | Event Listeners
    |--------------------------------------------------------------------------
    */
    'events' => [
        'auth.attempt' => [
            'Maatwebsite\Usher\Domain\Users\Events\Handlers\SaveLastAttemptDate',
            'Maatwebsite\Usher\Domain\Users\Events\Handlers\CheckIfUserIsBanned',
            'Maatwebsite\Usher\Domain\Users\Events\Handlers\CheckIfUserIsSuspended'
        ],
        'auth.login'   => [
            'Maatwebsite\Usher\Domain\Users\Events\Handlers\SaveLastLoginDate'
        ]
    ]

);
