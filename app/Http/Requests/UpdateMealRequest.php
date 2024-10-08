<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMealRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string',
            'name_ar' => 'string',
            'description' => 'string',
            'description_ar' => 'string',
            'image' => 'image|mimes:jpeg,png,jpg',
            'category_id' => [Rule::exists('categories', 'id')],
            'price' => 'numeric',
        ];
    }
}
