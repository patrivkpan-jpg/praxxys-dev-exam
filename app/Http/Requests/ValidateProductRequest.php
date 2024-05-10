<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateProductRequest extends FormRequest
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
        $validate = [
            '1' => [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'category' => 'required|exists:categories,name',
            ],
            '2' => [
                'images' => 'required',
                'images.*' => 'image'
            ],
            '3' => [
                'datetime' => 'required|date'
            ]
        ];
        
        return $validate[$this->step];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $description = (empty(strip_tags($this->description)) === true) ? null : strip_tags($this->description);
        $this->merge(['description' => $description]);
    }
}
