<?php

namespace App\Services\Helpers;

class Subnet
{
    /**
     * @param array $results
     * @return array
     */
    final public function __invoke(array $results): array
    {
        $subnets = [];

        foreach ($results as $result) {
            $subnets[] = (string)$result->byte1 . '.' . $result->byte2 . '.' . $result->byte3;
        }

        return $subnets;
    }
}
