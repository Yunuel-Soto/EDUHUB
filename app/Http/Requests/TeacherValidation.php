<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherValidation extends FormRequest
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
            'enrollment' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'career' => 'required',
            'startDate' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'enrollment.required' => 'Campo obligatorio',
            'firstName' => 'Campo obligatorio',
            'lastName' => 'Campo obligatorio',
            'career' => 'Campo obligatorio',
            'password' => 'Campo obligatorio',
            'password_confirmation.min' => 'Campo obligatorio',
        ];
    }
}