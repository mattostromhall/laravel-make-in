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
            'model' => env('PATH_BASE_MODEL', app_path('Models') . '/')
        ]
    ],
    'namespace' => [
        'base' => [
            'command' => env('NAMESPACE_BASE_COMMAND', app()->getNamespace() . 'Console\Commands'),
            'controller' => env('NAMESPACE_BASE_CONTROLLER', app()->getNamespace() . 'Http\Controllers'),
            'job' => env('NAMESPACE_BASE_JOB', app()->getNamespace() . 'Jobs'),
            'model' => env('NAMESPACE_BASE_MODEL', app()->getNamespace() . 'Models')
        ]
    ]
];
