<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
          'client' => new ClientResource($this->whenLoaded('client')),
          'pet' => new PetResource($this->whenLoaded('pet')),
          'employee' => new EmployeeResource($this->whenLoaded('employee')),
        ];
    }
}
