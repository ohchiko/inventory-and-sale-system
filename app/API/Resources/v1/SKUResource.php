<?php

namespace App\API\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class SKUResource extends JsonResource
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
            'id'            => (int) $this->id,
            'name'          => (string) $this->name,
            'description'   => (string) $this->description,
            'price'         => (float) $this->price,
            'components'    => ComponentResource::collection($this->whenLoaded('components')),
            'user'          => new UserResource($this->whenLoaded('user')),
            'createdAt'     => (string) $this->created_at->toDateTimeString(),
            'updatedAt'     => (string) $this->updated_at->toDateTimeString(),
            'deletedAt'     => (string) $this->deletedAt ?? $this->deleted_at->toDateTimeString()
        ];
    }
}
