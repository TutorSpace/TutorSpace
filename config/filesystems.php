<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'gcs'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        'public_user_photos' => [
            'driver' => 'local',
            'root' => storage_path('app/public_user_photos'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'endpoint' => env('AWS_URL'),
        ],

        'gcs' => [
            'driver' => 'gcs',
            'project_id' => env('GOOGLE_CLOUD_PROJECT_ID', 'your-project-id'),
            'key_file' => [
                'type' => env('GOOGLE_CLOUD_ACCOUNT_TYPE'),
                'private_key_id' => env('GOOGLE_CLOUD_PRIVATE_KEY_ID'),
                'private_key' => "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQDg3pTDkpvypqJ0\nibad2j/T98UR2e+2ASfJoDL5oQyweiGHozMTpH3+e6LFDldWw5X0Z5HQt87JHKrg\ncj+4w90yflVzp1fiRtU/JmmOqK3d7ZrDpp3uMKCbOFAZHsekNztaQ/6lHHK6GKZo\niindaTh+LRMugbbN2gGdTwMc19iQSrMISaj2KAzSdFkbnDFs4EpMgi6Hov1ENl+g\n2yypqoEnq6J/HlzgaMKhztNzGWpilzNtCCq9EATDe7YbDD3dhqLc+HVRPfpa4HB9\nv0Hk2Qch4KBR8UQf9s6u267cjeG0gB28oyvJrGIf1XJwREwA3WdopF8RV6SELe8J\nO73y2BLTAgMBAAECggEABkSGroVeMjZetrwFjVpYpEdZilYnyeMgoUaoI57Pf97W\n3Wl5I8GcM2riJYLCl87rJyAEcE7RbgOCUK/aK3gUqNuXDGv34SuqtgplARRYEnX9\npHZUHE63IGDONruTk/Xcgj0UTLTYyOAZ1R6+j4bnOielBYs8HmMAyG0ZIstDu7Of\nktuRAypX/SSMaXve0HRoCSh5UfQ3gCKhSaNpxWPv2CQEKoOYasxWQ790h8VLOr4L\n4TS8dWIClqnPEsrjTZQOIL1aXPJsCEu8yNgW1RUs1xEeBKxf17/ejYeJtzXQIX+5\n7Qggz98yayvQ8h0pZM4IfUHqlBF2Mr8A/QpJk88a0QKBgQDzR7ig9vM4I8E827EE\nHNaR9ElPhbTY5KDQipSJKEq8FiPiMKi1PuovQ5fHN5BUJ9T6fT42zTQbNfZsZvs6\n6muupdzNK267GGey8kOsubeVuYbiODNeo65b+4CaNJkNocOhqUyPYab/aRB3+ssy\nYnJxeNRNK0gJfTQOiZLDOrC60QKBgQDsoG9DBdA3kBeF1oC/BinYsJ7N1lCGFNfe\n+F12kMYMi1EJ+u2xLpWr8FYOp0fRStSO0qRBn8vP+kFstM3wVzBFjBBfnnJxOPye\nP9Dcj5gkzBuYdNg3RkQCnjgrXOyEuGHKJqhyEeG1uuIwQ+KLlJLFhUV21kN5CDjI\nJuJfDk+UYwKBgFS3tx2moY/9M3+j6YLLIBV3gkgFAbM9+ppkh9EzjMLu2tQbqcRk\nAl0vJp2jRclojYwlLRMcZnbLVeLuAbLEi3coHzn7U/YnS4VPRC3UBpBHKSeB9rGQ\nQlmZvXD1vA65NE0JjbWoheUPi0KcvUHwcnX9Y8Dzv4Q+a3BcjBUcTQrhAoGABOro\npQnv49e4xW1Jy66DHB+/jSORFNhGDDo5JwenNgeHLZ/rZK1FKweZokBTu8PEWxuB\nkmORxsa6qVmwlfgZ5rgcdwBB/Jxkk51b59mMHeeoAykafTuWmj9Th4Ms3y09ywe2\npHg+qpoxrTMb+C6kRjqY0Plu+Yr0MySru7H+cWUCgYBauupeE0IoOKeZpEW3HPz2\n7hWTwTjnPzadlxbQfLwh8olNjOphtQeV8mgve7I0XgEHQyRuXNRvhSeO8bQ9WZyJ\n4NVhFhEzdxePOiqWiwX9PyIeKU3Acv0DCvjPG1Ee6n30teaN+3g5C3uhxHmd+RCe\nhzDY17Xwwi42IdhOWt22RA==\n-----END PRIVATE KEY-----\n",
                'client_email' => env('GOOGLE_CLOUD_CLIENT_EMAIL'),
                'client_id' => env('GOOGLE_CLOUD_CLIENT_ID'),
                'auth_uri' => env('GOOGLE_CLOUD_AUTH_URI'),
                'token_uri' => env('GOOGLE_CLOUD_TOKEN_URI'),
                'auth_provider_x509_cert_url' => env('GOOGLE_CLOUD_AUTH_PROVIDER_CERT_URL'),
                'client_x509_cert_url' => env('GOOGLE_CLOUD_CLIENT_CERT_URL'),
            ],
            'bucket' => env('GOOGLE_CLOUD_STORAGE_BUCKET', 'your-bucket'),
            'path_prefix' => env('GOOGLE_CLOUD_STORAGE_PATH_PREFIX', null), // optional: /default/path/to/apply/in/bucket
            'storage_api_uri' => env('GOOGLE_CLOUD_STORAGE_API_URI', null), // see: Public URLs below
            'visibility' => 'public', // optional: public|private
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    // $photoUrl = asset('user_photos/img.png');
    'links' => [
        public_path('storage') => storage_path('app/public'),
        public_path('user_photos') => storage_path('app/public_user_photos'),
    ],

];
