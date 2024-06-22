<?php
return [
    /**
     * Inertia Modular Testing Configuration
     * **/
    'testing' => [

        'ensure_pages_exist' => true,

        'page_paths' => [

            resource_path(config('modules.paths.source')),

        ],

        'page_extensions' => [

            'js',
            'jsx',
            'svelte',
            'ts',
            'tsx',
            'vue',

        ],
    ]
];