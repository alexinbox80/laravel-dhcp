<?php

return [
    'debug' => true,
    'conf' => [
        'useDate' => true,
        'fileName' => env('DHCP_FILENAME', 'dhcpd.config'),
        'csvFile' => env('DHCP_CSV_FILENAME', 'cab_ip.csv'),
        'localPath' => env('DHCP_LOCAL_PATH', '/data'),
    ]
];
