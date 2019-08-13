<?php

namespace App\API\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => (int) $this->id,
            'name'      => (string) $this->name,
            'guardName' => (string) $this->guard_name
        ];
    }
}
