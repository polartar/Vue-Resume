<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateResumeWorkExperienceRequest extends FormRequest
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
            'position_title'         => 'string|nullable',
            'position_skill'         => 'string|nullable',
            'position_company'       => 'string|nullable',
            'position_start_date'    => 'date',
            'position_end_date'      => 'date|nullable',
            'current_employer'       => 'boolean',
        ];
    }
}
