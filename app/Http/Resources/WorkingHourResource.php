<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkingHourResource extends JsonResource
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
        'start_time' => $this->when(!is_null($this->start_time), $this->start_time),
        'end_time' => $this->when(!is_null($this->end_time), $this->end_time),
        'status' => $this->when(!is_null($this->status), $this->status)
      ];
    }
}
