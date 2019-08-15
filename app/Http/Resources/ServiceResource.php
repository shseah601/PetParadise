<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
      'price_min' => $this->when(!is_null($this->price_min), $this->price_min),
      'price_max' => $this->when(!is_null($this->price_max), $this->price_max),
      'duration' => $this->when(!is_null($this->duration), $this->duration),
      'capacity' => $this->when(!is_null($this->capacity), $this->capacity),
      'description' => $this->when(!is_null($this->description), $this->description),
      'image' => $this->when(!is_null($this->image), $this->image),
      'bookings' => BookingResource::collection($this->whenLoaded('bookings')),
      'pendingBookings' => PendingBookingResource::collection($this->whenLoaded('pendingBookings')),
    ];
  }
}
