<?php

return [
    'conf' => [
        'fileName' => env('DHCP_FILENAME', 'dhcpd.config'),
        'useDate' => true,
        'csvFile' => env('DHCP_CSV_FILENAME', 'cab_ip.csv'),
        'localPath' => env('DHCP_LOCAL_PATH', '/data'),
    ]
];
