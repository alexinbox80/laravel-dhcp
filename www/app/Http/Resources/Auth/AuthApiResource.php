<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [];

        if (isset($this->resource['id']))
            $response['id'] = $this->resource['id'];

        if (isset($this->resource['email']))
            $response['email'] = $this->resource['email'];

        if (isset($this->resource['expires_at']))
            $response['expires_at'] = $this->resource['expires_at'];

        if (isset($this->resource['expires_in']))
            $response['expires_in'] = $this->resource['expires_in'];

        $response = array_merge(
            $response,
            [
                'token_type' => 'Bearer',
                'access_token' => $this->resource['access_token']
            ]);

        if (isset($this->resource['refresh_token']))
            $response['refresh_token'] = $this->resource['refresh_token'];

        return $response;
    }
}
