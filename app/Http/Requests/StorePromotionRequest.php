<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePromotionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'code' => 'required|string|max:255',
            'discount_value' => 'required|numeric',
            'discount_type' => 'required|string|in:percentage,fixed',
            'status' => 'required|string|in:active,inactive',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_uses' => 'required|integer|min:1',
            'used_count' => 'nullable|integer|min:0',
        ];
    }
}
