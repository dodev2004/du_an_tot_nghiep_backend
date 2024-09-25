<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
class UpdateProductCatelogueRequest extends FormRequest
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
            "name"=>["required",Rule::unique("product_catelogues")->ignore($request->id)],
            "parent_id"=>"required", 
            "slug" => ["required",Rule::unique("product_catelogues")->ignore($request->id)],
        ];
    }
    public function messages()
    {
        return [
            "required" => ":attribute không được để trống",
            "parent_id.required" => "Bạn lên chọn danh mục sản phẩm",
            "unique" => ":attribute có vẻ đường dẫn này đã tồn tại",

        ];
    }
    public function attributes(){
        return [
            "name" => "Tên danh mục",
            "parent_id"=> "Danh mục sản phẩm",
            "slug"=> "Đường dẫn"
        ];
    }
}
