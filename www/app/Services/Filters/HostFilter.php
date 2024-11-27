<?php

namespace App\Services\Filters;

class HostFilter extends QueryFilter
{
    public function subnet($value): void
    {
        $value .= '.';
        if (!is_null($value))
            $this->builder->where('IP', 'LIKE',  "%{$value}%");
    }

    public function isEnable($value): void
    {
        if (!is_null($value))
            $this->builder->where('FLAG', (bool)$value === true);
    }
}
