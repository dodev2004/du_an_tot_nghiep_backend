<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductCatelogueRequest extends FormRequest
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
            "name"=>["required"],
            "parent_id"=>"required", 
            "slug" => ["required","unique:product_catelogues,slug"],
        ];
    }
    public function messages()
    {
        return [
            "required" => ":attribute không được để trống",
            "parent_id.required" => "Bạn lên chọn danh mục sản phẩm",
            "unique" => "Có vẻ đường dẫn này đã tồn tại",

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
