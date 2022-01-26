<?php

return [
    /*
     * The base path to be prefixed to the passed path argument.
     */
    'path' => [
        'base' => [
            'command' => env('PATH_BASE_COMMAND', app_path('Console/Commands') . '/'),
            'controller' => env('PATH_BASE_CONTROLLER', app_path('Http/Controllers') . '/'),
            'job' => env('PATH_BASE_JOB', app_path('Jobs') . '/'),
            'mail' => env('PATH_BASE_MAIL', app_path('Mail') . '/'),
            'model' => env('PATH_BASE_MODEL', app_path('Models') . '/'),
            'request' => env('PATH_BASE_REQUEST', app_path('Http/Requests') . '/')
        ]
    ],
    'namespace' => [
        'base' => [
            'command' => env('NAMESPACE_BASE_COMMAND', app()->getNamespace() . 'Console\Commands'),
            'controller' => env('NAMESPACE_BASE_CONTROLLER', app()->getNamespace() . 'Http\Controllers'),
            'job' => env('NAMESPACE_BASE_JOB', app()->getNamespace() . 'Jobs'),
            'mail' => env('NAMESPACE_BASE_MAIL', app()->getNamespace() . 'Mail'),
            'model' => env('NAMESPACE_BASE_MODEL', app()->getNamespace() . 'Models'),
            'request' => env('NAMESPACE_BASE_REQUEST', app()->getNamespace() . 'Http\Requests')        ]
    ]
];
