<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class UpdateUserRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        return [
            "email" => ["required", "email", Rule::unique("users")->ignore($request->id)],
            "username" => ["required", "min:6", Rule::unique("users")->ignore($request->id)], // Đảm bảo username cũng không bị trùng
            "full_name" => ["required", "string"],
            "role_id" => ["required"],
            "birthday" => ["nullable", "date"],
            "province_id" => ["required", "exists:provinces,code"], // Thêm kiểm tra tồn tại cho province_id
            "district_id" => ["required", "exists:districts,code"], // Thêm kiểm tra tồn tại cho district_id
            "ward_id" => ["required", "exists:wards,code"], // Thêm kiểm tra tồn tại cho ward_id
            "address" => ["required", "string"],
            "phone" => ["required", "string", "max:15"], // Giới hạn độ dài số điện thoại
        ];
    }
    public function  messages()
    {
        return [
            "required" => ":attribute không được để trống.",
            "role_id.required" => "Vui lòng chọn vai trò.",
            "min" => ":attribute phải dài hơn :min ký tự.",
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
            "full_name" => "Tên đầy đủ",
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
