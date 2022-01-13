<?php

return [
    /*
     * The base path to be prefixed to the passed path argument.
     */
    'path' => [
        'base' => [
            'model' => env('PATH_BASE_MODEL', app_path('Models') . '/'),
            'controller' => env('PATH_BASE_CONTROLLER', app_path('Http/Controllers') . '/')
        ]
    ],
    'namespace' => [
        'base' => [
            'model' => env('NAMESPACE_BASE_MODEL', 'App\Models'),
            'controller' => env('NAMESPACE_BASE_CONTROLLER', 'App\Http\Controllers')
        ]
    ]
];
