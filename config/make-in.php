<?php

return [
    /*
     * The base path to be prefixed to the passed path argument.
     */
    'path' => [
        'base' => [
            'command' => env('PATH_BASE_COMMAND', app_path('Console/Commands') . '/'),
            'controller' => env('PATH_BASE_CONTROLLER', app_path('Http/Controllers') . '/'),
            'model' => env('PATH_BASE_MODEL', app_path('Models') . '/')
        ]
    ],
    'namespace' => [
        'base' => [
            'controller' => env('NAMESPACE_BASE_CONTROLLER', 'App\Http\Controllers'),
            'model' => env('NAMESPACE_BASE_MODEL', 'App\Models')
        ]
    ]
];
