<?php

return [
    // change it to true will make lrd to throw exception if rules in request class need to be changed
    // keep it false
    'debug' => false,
    'document_name' => 'fenocity',

    /*
    * Route where request docs will be served from
    * localhost:8080/docs
    */
    'url' => 'docs',
    'middlewares' => [
        //Example
        // \App\Http\Middleware\NotFoundWhenProduction::class,
    ],

    /*
    * Default headers shown on the request headers editor
    */
    'default_request_headers' => [
        'Accept'        => 'application/json',
        'X-CSRF-TOKEN'  => '',
        'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNjc4MTA0Mzg0LCJleHAiOjE2OTk3MDQzODQsIm5iZiI6MTY3ODEwNDM4NCwianRpIjoiMzk5MzlhaFhkTVRPb1ZNaiIsInN1YiI6NCwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyIsInVzZXJJRCI6NCwidXNlclR5cGUiOiJBZG1pbiJ9.nSEDbbkJtTQXFaJ0-r6cDFzDMr1I9RoTjFnCtHt2c6A',
    ],

    /*
    * Show development relevant metadata on endpoints
    */
    'show_development_metadata' => true,

    /**
     * Path to to static HTML if using command line.
     */
    'docs_path' => base_path('public/docs'),

    /**
     * Sorting route by and there is two types default(route methods), route_names.
     */
    'sort_by' => 'route_names',

    //Use only routes where ->uri start with next string Using Str::startWith( . e.g. - /api/mobile
    'only_route_uri_start_with' => '',

    'hide_matching' => [
        '#^telescope#',
        '#^docs#',
        '#^docs#',
        '#^api-docs#',
        '#^sanctum#',
        '#^_ignition#',
        '#^_tt#',
    ],

    'request_methods' => [
        'rules',
        'onCreate',
        'onUpdate',
    ],

    'open_api' => [
        // default version that this library provides
        'version' => '3.0.0',
        // changeable
        'document_version' => '1.0.0',
        // license that you want to display
        'license' => 'Apache 2.0',
        'license_url' => 'https://www.apache.org/licenses/LICENSE-2.0.html',
        'server_url' => env('APP_URL', 'http://fenocity.herokuapp.com/'),

        // for now putting default responses for all. This can be changed later based on specific needs
        'responses' => [
            '200' => [
                'description' => 'Successful operation',
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'type' => 'object',
                        ],
                    ],
                ],
            ],
            '400' => [
                'description' => 'Bad Request',
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'type' => 'object',
                        ],
                    ],
                ],
            ],
            '401' => [
                'description' => 'Unauthorized',
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'type' => 'object',
                        ],
                    ],
                ],
            ],
            '403' => [
                'description' => 'Forbidden',
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'type' => 'object',
                        ],
                    ],
                ],
            ],
            '404' => [
                'description' => 'Not Found',
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'type' => 'object',
                        ],
                    ],
                ],
            ],
            '422' => [
                'description' => 'Unprocessable Entity',
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'type' => 'object',
                        ],
                    ],
                ],
            ],
            '500' => [
                'description' => 'Internal Server Error',
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'type' => 'object',
                        ],
                    ],
                ],
            ],
            'default' => [
                'description' => 'Unexpected error',
                'content' => [
                    'application/json' => [
                        'schema' => [
                            'type' => 'object',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
