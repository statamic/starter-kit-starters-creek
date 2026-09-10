<?php

return [
    'default' => 'blog',
    'indexes' => [
        'blog' => [
            'driver' => 'local',
            'searchables' => ['collection:blog'],
            'fields' => ['title', 'intro', 'main_content'],
        ],
    ],
    'drivers' => ['local' => ['path' => storage_path('statamic/search')]],
];
