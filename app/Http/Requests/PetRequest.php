<?php

namespace App\Http\Requests;

class PetRequest extends ApiFormRequest
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
            'type' => 'required|string|max:50',
            'gender' => 'required|string|max:1',
            'age' => 'required|integer'
        ];
    }
}
