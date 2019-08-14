<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
          'ic_no' => $this->when(!is_null($this->ic_no), $this->ic_no),
          'address' => $this->when(!is_null($this->address), $this->address),
          'gender' => $this->when(!is_null($this->gender), $this->gender),
          'dob' => $this->when(!is_null($this->dob), $this->dob),
          'phone' => $this->when(!is_null($this->phone), $this->phone),
          'user' => new UserResource($this->whenLoaded('user')),
          'bookings' => BookingResource::collection($this->whenLoaded('bookings')),  
        ];
    }
}
