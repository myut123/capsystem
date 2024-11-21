<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class registerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fname'=> ['required','alpha'],
            'mname'=> ['required','alpha'],
            'lname'=> ['required','alpha'],
            'emailReg'=> ['required','email'],
            'passwordReg'=>['required',],
        ];
    }
    public function messages()
    {
        return [
            'fname.required'=> 'Please Provide First Name',
            'mname.required'=> 'Please Provide Middle Name',
            'lname.required'=> 'Please Provide Last Name',
            'fname.alpha'=> 'Exclude Special Characters',
            'mname.alpha'=> 'Exclude Special Characters',
            'lname.alpha'=> 'Exclude Special Characters',
            'emailReg.required'=> 'Please Provide Email',
            'emailReg.email'=> 'Must be an Email',
            'passwordReg.required'=> 'Provide Password',
        ];
    }
}
