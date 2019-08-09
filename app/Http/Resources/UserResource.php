<?php

namespace App\Http\Resources;

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
          'id' => $this->when(!is_null($this->id), $this->id),
          'email' => $this->when(!is_null($this->email), $this->email),
          'admin' => new AdminResource($this->whenLoaded('admin')),
          'employee' => new EmployeeResource($this->whenLoaded('employee')),
          'client' => new ClientResource($this->whenLoaded('client'))
        ];
    }
}
