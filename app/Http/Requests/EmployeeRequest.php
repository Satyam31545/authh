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
        // $rules = [];
        // $rules['name'] = 'required';
        // if ($this->request->has('email')) {
        //     $rules['email'] = 'required|email';
        // }
        // if ($this->request->has('password')) {
        //     $rules['password'] = 'required';
        // }

        // $rules['role'] = 'required';
        // $rules['salary'] = 'required';
        // $rules['desigination'] = 'required';
        // $rules['dob'] = 'required';
        // $rules['address'] = 'required';
        // $rules['family.*.name'] = 'nullable';
        // $rules['family.*.age'] = 'nullable';
        // $rules['family.*.relation'] = 'nullable';
        // $rules['family.*.employeed'] = 'nullable';
        // $rules['education.*.edu_level'] = 'nullable';
        // $rules['education.*.course_n'] = 'nullable';
        // $rules['education.*.place'] = 'nullable';
        // $rules['education.*.percent'] = 'nullable';

        $rules = [
			'name' => [
				'required',
				'string'
			],
			'email' => [
				Rule::requiredIf($this->isMethod('post')),
				'string'
			],
			'password' => [
				Rule::requiredIf($this->isMethod('post')),
				'string'
			],
			'role' => [
				'required',
				'string'
			],
			'salary' => [
				'required',
				'string'
			],
			'desigination' => [
				'required',
				'string'
			],
			'dob' => [
				'required',
				'date_format:Y-m-d'
			],
			'address' => [
				'required',
				'string'
			],
			'family' => [
				'nullable',
				'array'
			],
			'family.*.name' => [
				'required',
				'string'
			],
			'family.*.age' => [
				'required',
				'string'
			],
			'family.*.relation' => [
				'required',
				'string'
			],
			'family.*.employeed' => [
				'required',
				'string'
			],
			'education' => [
				'nullable',
				'array'
			],
			'education.*.edu_level' => [
				'nullable',
				'string'
			],
			'education.*.course_n' => [
				'nullable',
				'string'
			],
			'education.*.place' => [
				'nullable',
				'string'
			],
			'education.*.percent' => [
				'nullable',
				'string'
			],
		];

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors(),
        ], 422));
    }
}
