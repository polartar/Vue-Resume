<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResumeEducationRequest extends FormRequest
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
            'resume_id'   => 'uuid|required',
            'school_name' => 'string|required',
            'type' => 'string|required',
            'degree_received' => 'string|nullable',
            'field_of_study' => 'string|nullable',
            'completed' => 'boolean|required',
            'start_date' => 'date|required',
            'end_date' => 'date|nullable',
            'currently_studying' => 'boolean|required',
            'resume_description_ids' => 'array|nullable',
        ];
    }
}
