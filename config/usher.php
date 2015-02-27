<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */
    'users'       => [
        'entity' => 'Maatwebsite\Usher\Domain\Users\UsherUser'
    ],
    /*
    |--------------------------------------------------------------------------
    | Roles
    |--------------------------------------------------------------------------
    */
    'roles'       => [
        'entity' => 'Maatwebsite\Usher\Domain\Roles\UsherRole'
    ],
    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    */

    'permissions' => [
        'strict' => true
    ],
    /*
    |--------------------------------------------------------------------------
    | Event Listeners
    |--------------------------------------------------------------------------
    */
    'events'      => [
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
