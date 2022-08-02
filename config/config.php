<?php

use Yfktn\TntSastrawi\Classes\TntSastrawiProviderTulisan;

return [
    'source' => [
        'driver'    => env('DB_CONNECTION', 'mysql'),
        'host'      => env('DB_HOST', 'localhost'),
        'database'  => env('DB_DATABASE', 'database'),
        'username'  => env('DB_USERNAME', 'user'),
        'password'  => env('DB_PASSWORD', 'password'),
        'storage'   => storage_path('tntsearch/'),
        'stemmer'   => Yfktn\TntSastrawi\Classes\IndonesianStemmer::class //option
    ],
    'provider' => [
        'Yfktn.Tulisan' => TntSastrawiProviderTulisan::class
    ]
];