<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Hash Driver
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default hash driver that will be used to
    | hash passwords for your application. By default, the bcrypt algorithm
    | is used; however, you remain free to modify this option if you wish.
    |
    | Supported: "bcrypt", "argon", "argon2id"
    |
    */

    'driver' => env('HASH_DRIVER', 'bcrypt'),

    /*
    |--------------------------------------------------------------------------
    | Bcrypt Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify the configuration options that should be used
    | when your application hashes passwords using the Bcrypt algorithm.
    | This will allow you to control the amount of time it takes to hash
    | the password.
    |
    */

    'bcrypt' => [
        'rounds' => env('BCRYPT_ROUNDS', 10),
    ],

    /*
    |--------------------------------------------------------------------------
    | Argon Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify the configuration options that should be used
    | when your application hashes passwords using the Argon algorithm.
    |
    */

    'argon' => [
        'memory'   => env('ARGON_MEMORY', 1024),
        'threads'  => env('ARGON_THREADS', 2),
        'time'     => env('ARGON_TIME', 2),
    ],

];
