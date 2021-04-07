<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResumeRequest extends FormRequest
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
            'user_id' => 'required|uuid',
            'name' => 'required|string',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'resume_design_id' => 'nullable|uuid',
            'pdf_url' => 'nullable|url',
            'user_address_id' => 'nullable|uuid',
            'user_phone_id' => 'nullable|uuid',
            'user_email_id' => 'nullable|uuid',
            'date_format' => 'integer',
        ];
    }
}
