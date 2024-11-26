<?php

return [
    'conf' => [
        'fileName' => env('DHCPD_FILENAME', 'dhcpd.conf'),
        'csvFile' => env('CSV_FILENAME', 'cab_ip.csv'),
        'localPath' =>env('DHCPD_LOCAL_PATH', '/data'),
    ]
];
