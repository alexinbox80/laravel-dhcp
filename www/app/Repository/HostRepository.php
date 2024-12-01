<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;

class HostRepository
{
    /**
     * @return array
     */
    public static function getSubnets(): array
    {
        /*
        -- TO_NUMBER(SPLIT_PART("IP", '.', 2), '99G999D9S') AS byte2,
        -- TO_NUMBER(SPLIT_PART("IP", '.', 3), '99G999D9S') AS byte3,

        SELECT
            TO_NUMBER('10', '99G999D9S') AS byte1,
            TO_NUMBER(REGEXP_SUBSTR("IP", '\d+', 1, 2), '99G999D9S') AS byte2,
            TO_NUMBER(REGEXP_SUBSTR("IP", '\d+', 1, 3), '99G999D9S') AS byte3,
            TO_NUMBER('0', '99G999D9S') AS byte4
        FROM
            dhcp_configs
        GROUP BY
            byte2, byte3
        ORDER BY
            byte2, byte3;
        */

        $query = "SELECT
                    TO_NUMBER('10', '99G999D9S') AS byte1,
                    TO_NUMBER(REGEXP_SUBSTR(\"IP\", '\d+', 1, 2), '99G999D9S') AS byte2,
                    TO_NUMBER(REGEXP_SUBSTR(\"IP\", '\d+', 1, 3), '99G999D9S') AS byte3,
                    TO_NUMBER('0', '99G999D9S') AS byte4
                  FROM
                    hosts
                  GROUP BY
                     byte2, byte3
                  ORDER BY
                     byte2, byte3;";

        return DB::select($query);
    }

    /**
     * @param string $subnet
     * @return array
     */
    public static function getHosts(string $subnet): array
    {
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
                  hosts
              WHERE "IP" LIKE '%10.65.%' AND "FLAG" = true
              ORDER BY
                  subnet, host;

        */

        $query = "SELECT
                    id, \"COMP\", \"IP\", \"MAC\", \"FLAG\",
                    TO_NUMBER(REGEXP_SUBSTR(\"IP\", '\d+', 1, 3), '99G999D9S') subnet,
                    TO_NUMBER(REGEXP_SUBSTR(\"IP\", '\d+', 1, 4), '99G999D9S') host
                FROM
                    hosts
                WHERE \"IP\" LIKE '%" . $subnet ."%' AND \"FLAG\" = true
                ORDER BY
                    subnet, host;";

        return DB::select($query);
    }
}
