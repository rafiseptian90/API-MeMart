<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
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
            'classroom_id' => 'required',
            'parent_completness_id' => 'required',
            'parent_income_id' => 'required',
            'other_criteria_id' => 'required',
            'name' => 'required',
            'gender' => 'required',
            'phone_number' => 'required',
            'card_type' => 'required',
            'card_number' => [
                'required',
                Rule::unique('profiles')->whereNull('deleted_at')
            ]
        ];
    }

    public function messages()
    {
        return [
            'classroom_id.required' => 'Classroom must be selected !',
            'parent_completness_id.required' => 'Parent Completness must be selected !',
            'parent_income_id.required' => 'Parent Income must be selected !',
            'other_criteria_id.required' => 'Other Criteria must be selected !',
            'name.required' => 'Name field must be filled !',
            'gender.required' => 'Gender field must be selected !',
            'phone_number.required' => 'Phone Number field must be filled !',
            'card_type.required' => 'Card Type field must be selected !',
            'nisn.unique' => 'This NISN has already been taken !'
        ];
    }
}
