<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserAddressRequest extends FormRequest
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
            'user_id' => 'uuid|required',
            'street_1' => 'string|nullable',
            'street_2' => 'string|nullable',
            'city' => 'string|required',
            'province' => 'string|required',
            'country' => 'string|nullable',
            'postal_code' => 'string|nullable',
        ];
    }
}
