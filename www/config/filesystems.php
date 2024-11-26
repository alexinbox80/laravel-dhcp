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

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

        'sftp' => [
            'driver' => 'sftp',
            'host' => env('SFTP_HOST'),
            // Settings for basic authentication...
            'username' => env('SFTP_USERNAME'),
            'password' => env('SFTP_PASSWORD'),
            'privateKey' => env('SFTP_PRIVATE_KEY'),
               // 'privateKey' => '/var/www/default/htdocs/storage/app/ssh/id_rsa',

//                'privateKey' => '-----BEGIN OPENSSH PRIVATE KEY-----
//b3BlbnNzaC1rZXktdjEAAAAABG5vbmUAAAAEbm9uZQAAAAAAAAABAAABlwAAAAdzc2gtcn
//NhAAAAAwEAAQAAAYEA2JvFU/Qq9saoT9HWvEK5fKnT3YsaJ/I+8ya1kyRMiIy1p19wIdes
//K6XyoUojT1dKzG/RNwsmOVUAMmsJYgT2xxxV4l1FAejDZToYBEUVBgcQ4EwlaDmgzA2Nzr
//E6WyuU7UuI0piL5NNIB8tF2QxcuygAW7BsO1Xdj/A+iRS4LpnrHrdzphYv5qKqMj3Nzwwh
//vLkL5op4hj8a9gUKdfJ8pynie9goieWXrWB7EcNBS1cnYm1KVvInBDG1rKuGeegE6FkFkz
//xFz02WWJevpF0nEZXBk1z8FLLinSsNX0rlHFNzYcqgK43kIsM9ToGtC7oNWS8gnf/7PJ47
//GnSeElk3QsAOI50yxMdITpVvX+aDhH3W6OB+j2XwwoFIrajps881l8XoanNrcge9R9wU2s
//wcWfyJUzjpAy5i5AZ7Ou9aEswee9KI2tSGK52Oe24ygk/vT/87vzs4k833nteKwCERDZUE
//qbrY+Ca9zYZWfktb43gOiDOs4BT/7SpxPSgMYQrDAAAFmH7f49t+3+PbAAAAB3NzaC1yc2
//EAAAGBANibxVP0KvbGqE/R1rxCuXyp092LGifyPvMmtZMkTIiMtadfcCHXrCul8qFKI09X
//Ssxv0TcLJjlVADJrCWIE9sccVeJdRQHow2U6GARFFQYHEOBMJWg5oMwNjc6xOlsrlO1LiN
//KYi+TTSAfLRdkMXLsoAFuwbDtV3Y/wPokUuC6Z6x63c6YWL+aiqjI9zc8MIby5C+aKeIY/
//GvYFCnXyfKcp4nvYKInll61gexHDQUtXJ2JtSlbyJwQxtayrhnnoBOhZBZM8Rc9NlliXr6
//RdJxGVwZNc/BSy4p0rDV9K5RxTc2HKoCuN5CLDPU6BrQu6DVkvIJ3/+zyeOxp0nhJZN0LA
//DiOdMsTHSE6Vb1/mg4R91ujgfo9l8MKBSK2o6bPPNZfF6Gpza3IHvUfcFNrMHFn8iVM46Q
//MuYuQGezrvWhLMHnvSiNrUhiudjntuMoJP70//O787OJPN957XisAhEQ2VBKm62Pgmvc2G
//Vn5LW+N4DogzrOAU/+0qcT0oDGEKwwAAAAMBAAEAAAGAEXN7Umg5jegzZzrgsgouJ30HNL
//IgSVea+rwDpPcns1iiyflGb3OQy3NzOMtgTOQbgpz/ng+n5LaUbXtyJhOATkpaIQKirKS0
//GVO026M1LmcjVO7NlLgP3GC7LAvbR70bIoMTYuQnYSgkhXw7BGGalvmCDeEI1z7zusUARM
//sGi7qa1r6w8pCXC13PmHyiOCwiC7Jc4xYE38v1wBxn21jN8inNtWyU14dH0RAU2jmA6TD8
//W1Gyy4521j+rA15OV0P5+0uxpIcFJSxfpornmGJbnEa6rfuKnufIwpiK3QgfuiQjqPVXBc
//e9RcBSz5h69TeN44Mr6QBIsTuXawQH58IiXDCGijpVDXA8UI9wcl8zJWrU8E+sYghIhZ3n
//u/AdASN5CKZ9vAuix44uXrWQFcIuqZPffq50/3o9IgoAt8FOzxTnzbcmnVQEzvADL8+UAH
//s1lMZy36m3rJjzfrvDTrn6tnKWp1js7eEgoVPdwSOuMssFu9KdbrTsKsIy4AsRPl8BAAAA
//wQDGSxqaQSkFmzTBiFV8/OtHYOgiiF91vRm2L+azyO+pW/jvR/Atqyk0pdN4Uh5FsOhf2U
//6KaPWsjFkoQ9uoKL9O+NOltcwxX/IfRYnQNTpuWfmogssoY3/tqH8NkX2/VURRjw/jkhFT
//FfzYGt7nY9Y6akzbJ6An5dBtxW8AidUqFZjTRHwM5emuko8sNFR2JIwX9S1s+p4MQCMurq
//SueC9Vm1QdecqzQBpSN8w/Ii2mwje3gNCzrWrzw5fvh+9fFQwAAADBAO6k7x6MFFQKXr3o
//DRfvV3WIsIp7SME2TYYNVsKHBrKosUV6sNt/I948A7tsEiDFoN/fl5LqFiHJjjSJ3e/C/n
//zu1GtVmeRN9dXVM5arJLfxdwrRzjhp15d9KD5SotiTjuR6Jif3LeMBmd3osPmemmip8G3J
//OcNplbPnpUx2Xty6HFRX4PFmJmKFx3sbif/FRl3vJ/NVQ8p2H5rOJyssnll1Lzfk4jpaXd
//843OYBwgba0jJlqQCOgrDvTS2MChwkpwAAAMEA6FyTV5CxqoKYbrtckicF+pR8ovStY6k0
//ZKDwhh+QuiiJnvqaN0sctFqXcfSC+x+3L4/zgfYBu/sLOF4yYCkgB53kpBFUO8HFPsZkCa
//MN5Xh6eolrNvPUOjg7G/NSbpqTfpFEdshSWXM7nPXGoK4RqdR8EcD18XRJfVmo2jRleJr7
//0jJM7liMotjWhmUXcLzKTctwl0/hFhzhumAsxS7yrtMsn6A6rZoF0u7ghya5Wp2ZGB14LD
//YPF9mCmD4UbgCFAAAAG2xleHhATWFjQm9vay1Qcm8tbGV4eC5sb2NhbAECAwQFBgc=
//    -----END OPENSSH PRIVATE KEY-----',

            'passphrase' => env('SFTP_PASSPHRASE'),
            'port' => env('SFTP_PORT', 22),
            'root' => env('SFTP_ROOT', '/var/ftp/public'),
            'visibility' => 'public', // `private` = 0600, `public` = 0644
            'directory_visibility' => 'private',
            'upload_path' => env('SFTP_UPLOAD_PATH'),
            'maxTries' => 4,
            'throw' => true,
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

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
