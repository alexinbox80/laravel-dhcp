<?php

namespace App\Http\Resources\Subnet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubnetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return string
     */
    public function toArray(Request $request): string
    {
        return $this->resource;
    }
}
