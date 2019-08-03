<?php

namespace App\Http\Requests;

use App\Rules\PhoneRule;

class EmployeeRequest extends ApiFormRequest
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
          'name' => 'required|string|max:100',
          'ic_no' => 'required|integer|digits:12',
          'address' => 'required|string|max:190',
          'gender' => 'required|string|max:1',
          'birth_date' => 'required|date_format:Y-m-d',
          'phone' => ['required', new PhoneRule],
        ];
    }
}
