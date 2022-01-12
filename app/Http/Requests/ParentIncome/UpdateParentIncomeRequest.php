<?php

namespace App\Http\Requests\ParentIncome;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateParentIncomeRequest extends FormRequest
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
                Rule::unique('parent_incomes')->ignore($this->route('parent_income'))->whereNull('deleted_at')
            ],
            'score' => 'required|integer|min:0|max:10'
        ];
    }
}
