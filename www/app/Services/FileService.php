<?php

namespace App\Services;

use App\Models\DhcpConfig;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileService
{
    /**
     * @param string $filePath
     * @return \Generator
     * @throws \Exception
     */
    public static function convertCsv(string $filePath): \Generator
    {
        $handle = fopen($filePath, 'rb');
        if (!$handle) {
            throw new \Exception();
        }

        fgetcsv($handle, separator: ";");
        // пока не достигнем конца файла
        while (!feof($handle)) {
            // читаем строку
            // и генерируем значение
            yield fgetcsv($handle, separator: ';');
        }

        // закрываем
        fclose($handle);
    }

    /**
     * @param string $filePath
     * @return bool
     * @throws \Exception
     */
    public static function convertProcess(string $filePath): bool
    {
        foreach (self::convertCsv($filePath) as $row) {
            if (!empty($row))
                DhcpConfig::create([
                    'CAB' => empty($row[0]) ? null : $row[0],
                    'F' => $row[1],
                    'I' => $row[2],
                    'O' => $row[3],
                    'COMP' => $row[4],
                    'IP' => $row[5],
                    'OLD_IP' => $row[8],
                    'MAC' => $row[6],
                    'INFO' => $row[7],
                    'FLAG' => empty($row[11]) ?? false,
                    'DT_REG' => new \DateTime($row[9]),
                    'DT_UPD' => new \DateTime($row[12])
                ]);
        }

        return true;
    }

    public static function makeDhcpConfig(string $filePath): bool
    {
        $fileDescriptor = fopen($filePath, "w");
        if (!$fileDescriptor) {
            throw new \Exception();
        }

        fwrite($fileDescriptor, "authoritative;\n");
        fwrite($fileDescriptor, "ddns-update-style interim;\n");
        fwrite($fileDescriptor, "#ignore client-updates;\n");
        fwrite($fileDescriptor, "allow bootp;\n");
        fwrite($fileDescriptor, "allow booting;\n");

        fwrite($fileDescriptor, "option option-128 code 128 = string;\n");
        fwrite($fileDescriptor, "option option-129 code 129 = string;\n");
        fwrite($fileDescriptor, "option arch code 93 = unsigned integer 16;\n");

        fwrite($fileDescriptor, "\n");

        fwrite($fileDescriptor, "log-facility local6;\n");
        fwrite($fileDescriptor, "\n");

        fwrite($fileDescriptor, "#Time Of Address Live...\n");
        fwrite($fileDescriptor, "# 10 min esli klient ne zaprosil vremja arendi\n");
        fwrite($fileDescriptor, "default-lease-time 600;\n");
        fwrite($fileDescriptor, "# 10 min esli zaprosil\n");
        fwrite($fileDescriptor, "max-lease-time 600;\n");
        fwrite($fileDescriptor, "\n");
        fwrite($fileDescriptor, "# Domain name\n");
        fwrite($fileDescriptor, "option domain-name \"mvdrk.ru\";\n");
        fwrite($fileDescriptor, "\n");
        fwrite($fileDescriptor, "# Mashini Kotorim mozhno... (EITKS 10.65.0.0/16)\n");
        fwrite($fileDescriptor, "shared-network mvd-po-rk {\n");
        fwrite($fileDescriptor, "\n");
        fwrite($fileDescriptor, "subnet 10.65.0.0 netmask 255.255.0.0 {\n");
        fwrite($fileDescriptor, "## Ne zhelaemaja set' Levie Mashini ... (EITKS 10.65.255.0/24)\n");
        fwrite($fileDescriptor, "option time-offset 3; # Moscow Time\n");
        fwrite($fileDescriptor, "option subnet-mask 255.255.255.255;\n");
        fwrite($fileDescriptor, "\n");
        fwrite($fileDescriptor, "class \"pxeclients\" {\n");
        fwrite($fileDescriptor, "	match if substring (option vendor-class-identifier, 0, 9) =  \"PXEClient\"; \n");
        fwrite($fileDescriptor, "	next-server 10.65.121.14;\n");
        fwrite($fileDescriptor, "\n");
        fwrite($fileDescriptor, "	if option arch = 00:06 {\n");
        fwrite($fileDescriptor, "		filename \"bootia32.efi\";\n");
        fwrite($fileDescriptor, "	} else if option arch = 00:07 {\n");
        fwrite($fileDescriptor, "		filename \"boot/grub/x86_64-efi/core.efi\";\n");
        fwrite($fileDescriptor, "		} else {\n");
        fwrite($fileDescriptor, "		filename \"pxelinux.0\";\n");
        fwrite($fileDescriptor, "		}\n");
        fwrite($fileDescriptor, "}\n");
        fwrite($fileDescriptor, "\n");
        fwrite($fileDescriptor, "group {\n");
        fwrite($fileDescriptor, "\n");
        fwrite($fileDescriptor, "local-address 10.65.121.21;\n");
        fwrite($fileDescriptor, "\n");
        fwrite($fileDescriptor, "#Time Of Address Live...\n");
        fwrite($fileDescriptor, "# 3 Sutok esli klient ne zaprosil vremja arendi\n");
        fwrite($fileDescriptor, "default-lease-time 259200;\n");
        fwrite($fileDescriptor, "# 7 sutok esli zaprosil\n");
        fwrite($fileDescriptor, "max-lease-time 604800;\n");
        fwrite($fileDescriptor, "option domain-name \"mvdrk.ru\";\n");
#	fwrite($fileDescriptor, "option domain-name-servers 10.65.121.13, 10.65.121.10;\n");
        fwrite($fileDescriptor, "option domain-name-servers 10.65.121.13, 172.26.138.3;\n");
        fwrite($fileDescriptor, "option subnet-mask 255.255.0.0;\n");
        fwrite($fileDescriptor, "option broadcast-address 10.65.255.255;\n");
        fwrite($fileDescriptor, "option routers 10.65.0.20;\n");

        fwrite($fileDescriptor, "\n");

        $query = "SELECT id, \"COMP\", \"IP\", \"MAC\",
                        TO_NUMBER(REGEXP_SUBSTR(\"IP\", '\d+', 1, 3), '99G999D9S') subnet,
                        TO_NUMBER(REGEXP_SUBSTR(\"IP\", '\d+', 1, 4), '99G999D9S') host
                FROM
                    dhcp_configs
                WHERE \"IP\" LIKE '%10.65.%'
                ORDER BY
                    subnet, host;";

        $hosts = DB::select($query);

//        $hosts = DhcpConfig::query()
//            ->where('IP', 'LIKE', "%10.64.%")
//            //->orderBy('IP', 'ASC')
//            //->orderBy('COMP', 'ASC')
//            ->get();

        $prevSubnet = "";

        foreach ($hosts as $host) {
            if ($host->subnet != $prevSubnet) {
                $prevSubnet = $host->subnet;
                fwrite($fileDescriptor, "\n# ------------------------- " . $host->IP . " ------------------------------------------ \n\n");
            }

            fwrite($fileDescriptor, "host ");
            fwrite($fileDescriptor, $host->COMP);
            fwrite($fileDescriptor, " { hardware ethernet ");
            fwrite($fileDescriptor, $host->MAC);
            fwrite($fileDescriptor, "; fixed-address ");
            fwrite($fileDescriptor, $host->IP);
            fwrite($fileDescriptor, "; }");
            fwrite($fileDescriptor, "\n");
        }

        fwrite($fileDescriptor, "\n");
        fwrite($fileDescriptor, "\n} #group\n");
        fwrite($fileDescriptor, "\n");
        fwrite($fileDescriptor, "# Krome\n");
        fwrite($fileDescriptor, "range 10.65.255.0 10.65.255.254;\n");
        fwrite($fileDescriptor, "group {\n");
        fwrite($fileDescriptor, "## Ne zhelaemaja set' Levie Mashini ... (EITKS 10.65.255.0/24)\n");
        fwrite($fileDescriptor, "option broadcast-address 10.65.255.255;\n");
        fwrite($fileDescriptor, "\n");
        fwrite($fileDescriptor, "\n} #group Krome\n");
        fwrite($fileDescriptor, "} #subnet 10.65.0.0 \n");
        fwrite($fileDescriptor, "} #shared network \n");

//        $stq = oci_parse($c, "SELECT id, comp, ip, mac, to_number(REGEXP_SUBSTR(ip, '\d+', 1, 3)) subnet, to_number(REGEXP_SUBSTR(ip, '\d+', 1, 4)) host FROM CAB_IP WHERE ip LIKE '10.64.%' ORDER BY subnet, host");
//
//        oci_execute($stq);

        fwrite($fileDescriptor, "\n");


        fwrite($fileDescriptor, "subnet 10.64.0.0 netmask 255.255.0.0 {\n");

        fwrite($fileDescriptor, "\n");

        fwrite($fileDescriptor, "\n");
        fwrite($fileDescriptor, "local-address 10.65.121.21;\n");
        fwrite($fileDescriptor, "\n");


        fwrite($fileDescriptor, "#log(info, \"*10.64*\");\n");
        fwrite($fileDescriptor, "\n");
        fwrite($fileDescriptor, "class \"10-64-101-1\" { match if binary-to-ascii(10,8,\".\",packet(24,4))=\"10.64.101.1\"; }\n");
        fwrite($fileDescriptor, "pool {\n");
        fwrite($fileDescriptor, "	range 10.64.101.255 10.64.101.255;\n");
        fwrite($fileDescriptor, "	option broadcast-address 10.64.101.255;\n");
        fwrite($fileDescriptor, "	option routers 10.64.101.1;\n");
        fwrite($fileDescriptor, "	#Time Of Address Live...\n");
        fwrite($fileDescriptor, "	# 3 Sutok esli klient ne zaprosil vremja arendi\n");
        fwrite($fileDescriptor, "	default-lease-time 259200;\n");
        fwrite($fileDescriptor, "\n");



        fwrite($fileDescriptor, "	# 7 sutok esli zaprosil\n");
        fwrite($fileDescriptor, "	max-lease-time 604800;\n");
        fwrite($fileDescriptor, "	option domain-name \"umvd.mvdrk.ru\";\n");
#	fwrite($fileDescriptor, "	option domain-name-servers 10.65.121.13, 10.65.121.10;\n");
        fwrite($fileDescriptor, "	option domain-name-servers 10.65.121.13, 172.26.138.3;\n");
        fwrite($fileDescriptor, "	option subnet-mask 255.255.255.0;\n");
        fwrite($fileDescriptor, "\n");


        /*
        pgSql

            SELECT
                id,
                "COMP",
                "IP",
                "MAC",
                TO_NUMBER(REGEXP_SUBSTR("IP", '\d+', 1, 3), '99G999D9S') subnet,
                TO_NUMBER(REGEXP_SUBSTR("IP", '\d+', 1, 4), '99G999D9S') host
            FROM
                dhcp_configs
            WHERE "IP" LIKE '%10.65.%'
            ORDER BY
                subnet, host;

         */

//        $query = "SELECT id, \"COMP\", \"IP\", \"MAC\",
//                        TO_NUMBER(REGEXP_SUBSTR(\"IP\", '\d+', 1, 3), '99G999D9S') subnet,
//                        TO_NUMBER(REGEXP_SUBSTR(\"IP\", '\d+', 1, 4), '99G999D9S') host
//                FROM
//                    dhcp_configs
//                WHERE \"IP\" LIKE '%10.65.%'
//                ORDER BY
//                    subnet, host;";
//
//        $hosts   =   DB::select($query);
//
////        $hosts = DhcpConfig::query()
////            ->where('IP', 'LIKE', "%10.64.%")
////            //->orderBy('IP', 'ASC')
////            //->orderBy('COMP', 'ASC')
////            ->get();
//
//        $prevSubnet = "";
//
//        foreach ($hosts as $host) {
//            if ($host->subnet != $prevSubnet) {
//                $prevSubnet = $host->subnet;
//                fwrite($fileDescriptor, "\n# ------------------------- " . $host->IP . " ------------------------------------------ \n\n");
//            }
//
//            fwrite($fileDescriptor, "host ");
//            fwrite($fileDescriptor, $host->COMP);
//            fwrite($fileDescriptor, " { hardware ethernet ");
//            fwrite($fileDescriptor, $host->MAC);
//            fwrite($fileDescriptor, "; fixed-address ");
//            fwrite($fileDescriptor, $host->IP);
//            fwrite($fileDescriptor, "; }");
//            fwrite($fileDescriptor, "\n");
//        }

        fwrite($fileDescriptor, "\n");
        fwrite($fileDescriptor, "allow members of \"10-64-101-1\";\n");
        fwrite($fileDescriptor, "} #pool\n");
        fwrite($fileDescriptor, "\n");

        fwrite($fileDescriptor, "# Krome\n");
        fwrite($fileDescriptor, "range 10.64.255.0 10.64.255.254;\n");
        fwrite($fileDescriptor, "group {\n");
        fwrite($fileDescriptor, "## Ne zhelaemaja set' Levie Mashini ... (EITKS 10.64.255.0/24)\n");
        fwrite($fileDescriptor, "option broadcast-address 10.64.255.255;\n");
        fwrite($fileDescriptor, "\n");
        fwrite($fileDescriptor, "\n} #group Krome\n");

        fwrite($fileDescriptor, "#if (exists agent.circuit-id) {\n");
        fwrite($fileDescriptor, "#    log ( info, concat( \"Lease for \", binary-to-ascii (10, 8, \".\", leased-address),\n");
        fwrite($fileDescriptor, "#                     \"Switch port: \", binary-to-ascii (10, 8, \".\", option agent.circuit-id),\n");
        fwrite($fileDescriptor, "#                     \"Switch MAC: \", binary-to-ascii (16, 8, \".\", option agent.remote-id)));\n");
        fwrite($fileDescriptor, "#} else {\n");
        fwrite($fileDescriptor, "#    log ( info, concat(\" *Liased \", binary-to-ascii(10, 8, \".\", leased-address), \" without opt82\"));\n");
        fwrite($fileDescriptor, "#    log ( info, concat(\" Switch port: \", binary-to-ascii(10, 8, \".\", option agent.circuit-id), \" without opt82\"));\n");
        fwrite($fileDescriptor, "#    log ( info, concat(\" Switch MAC: \", binary-to-ascii(16, 8, \".\", option agent.remote-id), \" without opt82\"));\n");
        fwrite($fileDescriptor, "#    log ( info, concat(\" Relay IP Agent: \", binary-to-ascii(10, 8, \".\", packet(24,4)), \" without opt82\"));\n");
        fwrite($fileDescriptor, "#}\n");

        fwrite($fileDescriptor, "#log(info, \"*10.64*\");\n");
        fwrite($fileDescriptor, "\n");
        fwrite($fileDescriptor, "}\n");

        fclose($fileDescriptor);

        return true;
    }

    public static function putDhcpConfig(): null | bool
    {
        $fileName = config('dhcpd.conf.fileName');
        $localPath = config('dhcpd.conf.localPath');

        $dhcpFile = Storage::disk('public')->get(
            $localPath . '/' .
            $fileName
        );
        if (!$dhcpFile) return $dhcpFile;

        $currentMinute = date('i');

        $result = Storage::disk('sftp')->put(
                config('filesystems.disks.sftp.upload_path')
                . '/'
                . $fileName
                . '.'
                . $currentMinute, $dhcpFile);
        if (!$result) return $result;

        return true;
    }
}
