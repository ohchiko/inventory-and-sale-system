<?php

namespace App\API\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email'     => (string) $this->email,
            'createdAt' => (string) $this->created_at->toDateTimeString(),
            'updatedAt' => (string) $this->updated_at->toDateTimeString(),
            'deletedAt' => (string) $this->deleted_at ?? $this->deleted_at->toDateTimeString()
        ];
    }
}
