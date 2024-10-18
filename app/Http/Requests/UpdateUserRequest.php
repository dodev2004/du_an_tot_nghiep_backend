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
            "email"=> ["required", "email",Rule::unique("users")->ignore($request->id)],
            "username"=> ["required","min:8"],
            // "rule_id" => ["required"],
        ];
    }
    public function  messages()
    {
        return [
            "required"=> ":attribute không được để trống",
            "rule_id.required" => "Vui lòng chọn mục này",
            "min" => ":attribute phải dài hơn :value kí tự",
            "email.email"=> ":attribute phải đúng định dạng vd:'abv@gmail.com'",
            "email.unique"=> "Email đã tồn tại"
        ];
    }
    public function attributes(){
        return [
            "email"=>"Email",
            "Fullname"=>"Tên đầy đủ",
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
