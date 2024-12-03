<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
class StoreUserRequest extends FormRequest
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
            "email" => ["required", "email", "unique:App\Models\User,email"],
            "password" => ["required", "min:6", "string"],
            "re-password" => ["required", "min:6", "string", "same:password"],
            "username" => ["required", "min:6", "unique:App\Models\User,username"],
            "role_id" => ["required"], // Bắt buộc phải chọn vai trò
            "birthday" => ["nullable", "date"], // Ngày sinh (không bắt buộc)
            "province_id" => ["required"], // Thành phố (không bắt buộc)
            "district_id" => ["required"], // Quận (không bắt buộc)
            "ward_id" => ["required"], // Phường (không bắt buộc)
            "address" => ["required", "string"], // Địa chỉ (không bắt buộc)
            "phone" => ["required", "string", "max:15"], // Số điện thoại (không bắt buộc)
        ];
    }
    public function  messages()
    {
        return [
            "required" => ":attribute không được để trống.",
            "role_id.required" => "Vui lòng chọn vai trò.",
            "min" => ":attribute phải dài hơn :min ký tự.",
            "re-password.same" => "Mật khẩu nhập lại không trùng khớp.",
            "email.email" => ":attribute phải đúng định dạng, ví dụ: 'abv@gmail.com'.",
            "email.unique" => "Email đã tồn tại.",
            "username.unique" => "Tên đăng nhập đã tồn tại.",
            "birthday.date" => ":attribute phải là ngày hợp lệ.",
            "province_id.exists" => "Thành phố không tồn tại.",
            "district_id.exists" => "Quận không tồn tại.",
            "ward_id.exists" => "Phường không tồn tại.",
            "phone.max" => ":attribute không được vượt quá :max ký tự.",
        ];
    }
    public function attributes(){
        return [
            "email" => "Email",
            "username" => "Tên đăng nhập",
            "password" => "Mật khẩu",
            "re-password" => "Nhập lại mật khẩu",
            "role_id" => "Vai trò",
            "birthday" => "Ngày sinh",
            "province_id" => "Thành phố",
            "district_id" => "Quận",
            "ward_id" => "Phường",
            "address" => "Địa chỉ",
            "phone" => "Số điện thoại",
        ];
    }
    public function after(){
        return [
            function(Validator $validator){
                if($validator->errors()->count() > 0){
                    $validator->errors()->add("msg","Một số trường không hợp lệ");
                }
            }
        ];
    }
}
