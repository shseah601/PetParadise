<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PendingBookingRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'client_id' => 'required|integer',
      'pet_id' => 'required|integer',
      'start_time' => 'required|date_format:Y-m-d H:i:s',
      'end_time' => 'required|date_format:Y-m-d H:i:s',
      'status' => 'required|string'
    ];
  }
}
