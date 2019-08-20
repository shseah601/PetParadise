<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PendingBookingResource extends JsonResource
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
      'start_time' => $this->when(!is_null($this->start_time), $this->start_time),
      'end_time' => $this->when(!is_null($this->end_time), $this->end_time),
      'status' => $this->when(!is_null($this->status), $this->status),
      'created_at' => $this->when(!is_null($this->created_at), $this->created_at),
      'client' => new ClientResource($this->whenLoaded('client')),
      'pet' => new PetResource($this->whenLoaded('pet')),
      'service' => new ServiceResource($this->whenLoaded('service'))
    ];
  }
}
