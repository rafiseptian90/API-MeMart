<?php

namespace App\Http\Requests\OtherCriteria;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOtherCriteriaRequest extends FormRequest
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
            'name' => [
                'required',
                Rule::unique('other_criterias')->ignore($this->route('other_criteria'))->whereNull('deleted_at')
            ],
            'score' => 'required|integer|min:0|max:10'
        ];
    }
}
