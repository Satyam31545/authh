<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
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
        $rules = [];
        $rules['name'] = 'required';
        $rules['email'] = Rule::requiredIf($this->isMethod('post'));
        $rules['password'] = Rule::requiredIf($this->isMethod('post'));
        $rules['employee_id'] = [Rule::requiredIf($this->isMethod('post')),'unique:App\Models\Employee,employee_id'];
        $rules['role'] = 'required';
        $rules['salary'] = 'required';
        $rules['desigination'] = 'required';
        $rules['dob'] = 'required';
        $rules['address'] = 'required';
        $rules['family.*.name'] = 'nullable';
        $rules['family.*.age'] = 'nullable';
        $rules['family.*.relation'] = 'nullable';
        $rules['family.*.employeed'] = 'nullable';
        $rules['education.*.edu_level'] = 'nullable';
        $rules['education.*.course_n'] = 'nullable';
        $rules['education.*.place'] = 'nullable';
        $rules['education.*.percent'] = 'nullable';
        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 422));
    }
}
