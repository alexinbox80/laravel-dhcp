<?php

namespace App\Http\Resources\Host;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'CAB' => $this->CAB,
            'F' => $this->F,
            'I' => $this->I,
            'O' => $this->O,
            'IP' => $this->IP,
            'OLD_IP' => $this->OLD_IP,
            'MAC' => $this->MAC,
            'INFO' => $this->INFO,
            'FLAG' => $this->FLAG,
            'DT_REG' => $this->DT_REG,
            'DT_UPD' => $this->DT_UPD
        ];
    }
}
