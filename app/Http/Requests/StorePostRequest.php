<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            "title"=>["required"],
            "slug" => ["required","unique:App\Models\Post,slug"],
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
        ];
    }
}
