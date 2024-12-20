<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'user_id' => 'required|integer',
            'name' => 'required|string|max:255|unique:products,name',
            'detailed_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'meta_description' => 'nullable|string|max:255',
            'brand_id_' => 'nullable|integer',
            'sku' => 'nullable|required|string|max:255|unique:products,sku',
            'price' => 'required|numeric|min:0|max:99999999',
            'discount_price' => 'nullable|numeric|min:0|lt:price|max:99999999',
            'stock' => 'required|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'status' => 'required|boolean',
        ];
    }
    public function attributes()
    {
        return [
            'user_id' => 'ID người dùng',
            'name' => 'Tên sản phẩm',
            'detailed_description' => 'Mô tả chi tiết',
            'meta_keywords' => 'Từ khóa SEO',
            'slug' => 'Slug',
            'meta_description' => 'Mô tả SEO',
            'brand_id_' => 'ID thương hiệu',
            'sku' => 'Mã sản phẩm',
            'price' => 'Giá',
            'discount_price' => 'Giá giảm',
            'stock' => 'Tồn kho',
            'weight' => 'Khối lượng',
            'status' => 'Trạng thái kích hoạt',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Vui lòng nhập người dùng.',
            'user_id.integer' => 'ID người dùng phải là một số nguyên.',

            'name.required' => 'Tên sản phẩm là bắt buộc',
            'name.max' => 'Tên sản phẩm không được vượt quá :max ký tự.',
            'name.unique' => "Tên sản phẩm đã tồn tại",
            'detailed_description.string' => 'Mô tả chi tiết phải là một chuỗi.',

            'meta_keywords.string' => 'Từ khóa SEO phải là một chuỗi.',
            'meta_keywords.max' => 'Từ khóa SEO không được vượt quá :max ký tự.',

            'slug.string' => 'Slug phải là một chuỗi.',
            'slug.max' => 'Slug không được vượt quá :max ký tự.',
            'slug.unique' => "Slug đã tồn tại",
            'meta_description.string' => 'Mô tả SEO phải là một chuỗi.',
            'meta_description.max' => 'Mô tả SEO không được vượt quá :max ký tự.',

            'brand_id_.integer' => 'Thương hiệu phải là một số nguyên.',

            'sku.required' => 'Mã sản phẩm là bắt buộc.',
            'sku.max' => 'Mã sản phẩm không được vượt quá :max ký tự.',
            'sku.unique' => "Mã sản phẩm đã tồn tại",
            'price.required' => 'Vui lòng nhập giá sản phẩm.',
            'price.numeric' => 'Giá sản phẩm phải là một số hợp lệ.',
            'price.min' => 'Giá sản phẩm phải lớn hơn hoặc bằng 0.',
            'price.max' => 'Giá sản phẩm không được vượt quá 1 tỷ',
            'discount_price.numeric' => 'Giá giảm phải là một số hợp lệ.',
            'discount_price.min' => 'Giá giảm phải lớn hơn hoặc bằng 0.',
            'discount_price.lt' => 'Giá giảm phải nhỏ hơn giá sản phẩm.',
            'discount_price.max' => 'Giá giảm không được vượt quá 1 tỷ',
            'stock.required' => 'Số lượng tồn kho là bắt buộc.',
            'stock.integer' => 'Số lượng tồn kho phải là một số nguyên.',
            'stock.min' => 'Số lượng tồn kho phải lớn hơn hoặc bằng 0.',

            'weight.numeric' => 'Khối lượng phải là một số hợp lệ.',
            'weight.min' => 'Khối lượng phải lớn hơn hoặc bằng 0.',

            'image_url.url' => 'URL hình ảnh không hợp lệ.',

            'status.required' => 'Trạng thái kích hoạt là bắt buộc.',
            'status.boolean' => 'Trạng thái kích hoạt phải là true hoặc false.',

            
        ];
    }
}
