<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            "email"=>["required","email"],
            "password"=>["required"]
        ];
    }
    public function messages()
    {
        return [
            "email.required"=>"Email không được để trống",
            "password.required"=>"Password không được để trống",
            "email.email"=>"Email phải đúng định dạng",
        ];
    }
}
