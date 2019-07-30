<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
        'id' => $this->when(!is_null($this->id), $this->id),
        'name' => $this->when(!is_null($this->name), $this->name),
        'address' => $this->when(!is_null($this->address), $this->address),
        'phone' => $this->when(!is_null($this->phone), $this->phone),
        'user_id' => $this->when(!is_null($this->user_id), $this->user_id),
        'pets' => PetResource::collection($this->whenLoaded('pets')),
        'bookings' => BookingResource::collection($this->whenLoaded('bookings')),
      ];
    }
}
