<?php

namespace App\Http\Requests\backend;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "Fullname"=>"required",
            "email"=>"required|email|unique:App\Models\User,email",
            "password"=>"required|min:6|max:20",
        ];
    }
    public function messages()
    {
        return [
            "required" => ":attribute không được để trống",
            "email" => "Định dạng phải là email",
            "unique"=> "Email đã tồn tại",
            "min" => ":attribute phải dài hơn :value kí tự",
            "max" => ":attribute phải ngắn hơn :value kí tự",
        ];
    }
    public function attributes()
    {
        return [
            "Fullname" => "Tên",
            "email" => "Email",
            "password" => "Mật khẩu"
        ];
    }
}
