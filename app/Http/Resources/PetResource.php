<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PetResource extends JsonResource
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
      'type' => $this->when(!is_null($this->type), $this->type),
      'gender' => $this->when(!is_null($this->gender), $this->gender),
      'age' => $this->when(!is_null($this->age), $this->age),
      'client' => new ClientResource($this->whenLoaded('client')),
      'bookings' => BookingResource::collection($this->whenLoaded('bookings')),
      'pendingBookings' => PendingBookingResource::collection($this->whenLoaded('pendingBookings')),

    ];
  }
}
