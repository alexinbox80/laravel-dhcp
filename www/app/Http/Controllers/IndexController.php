<?php

namespace App\Http\Controllers;

use App\Models\Host;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
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

        $results = DB::select($query);

        $subnets = [];
        foreach ($results as $result) {
            $subnets[] = $result->byte1 . '.' . $result->byte2 . '.' . $result->byte3;
        }

        $hosts = Host::query()->orderBy('DT_REG', 'desc')->take('45')->get();
        return view('index', ['subnets' => $subnets, 'hosts' => $hosts]);
    }
}
