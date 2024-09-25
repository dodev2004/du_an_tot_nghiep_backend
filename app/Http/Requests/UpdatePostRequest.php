<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdatePostRequest extends FormRequest
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
            "title"=>["required"],
            "slug" => ["required",Rule::unique("posts")->ignore(request()->id)],
            "meta_description" => ["required"],
            "meta_keywords" => ["required"],
            "content"=>["required"],
        ];
    }
    public function messages()
    {
        return [
            "required" => ":attribute không được để trống",
            "unique" => "Có vẻ đường dẫn này đã tồn tại",
        ];
    }
    public function attributes(){
        return [
            "title" => "Tiêu đề bài viết",
            "slug"=> "Đường dẫn",
            "meta_keywords" => "Từ khóa chính",
            "content" => "Nội dung",
            "meta_description" => "Mô tả"
        ];
    }
}
