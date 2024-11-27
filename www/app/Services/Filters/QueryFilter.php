<?php

namespace App\Services\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class QueryFilter
{
    protected Builder $builder;
    protected Request $request;

    public function __construct($builder, $request)
    {
        $this->builder = $builder;
        $this->request = $request;
    }

    public function apply(): Builder
    {
        foreach ($this->filters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    public function filters(): array
    {
        return  $this->request->all();
    }
}
