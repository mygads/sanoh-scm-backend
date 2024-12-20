<?php

namespace App\Http\Requests;

use App\Models\SubcontItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubcontItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role == 5;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "item_code"=> "required|string|max:50",
            "item_name"=> "required|string|max:255",
        ];
    }

    public function messages(): array
    {
        return [
            // item_code
            'item_code.required' => 'The item code is required.',
            'item_code.string' => 'The item code must be a valid string.',
            'item_code.max' => 'The item code cannot be longer than 50 characters.',

            // item_name
            'item_name.required' => 'The item name is required.',
            'item_name.string' => 'The item name must be a valid string.',
            'item_name.max' => 'The item name cannot be longer than 255 characters.',
        ];
    }

    // Failed validation response
    protected function failedValidation($validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }

    // Check if item_code already exist
    // Call the withValidation method (method injection from formRequest.php. it's core of framework method)
    protected function withValidator($validator){
        $this->duplicateCheck($validator);
    }

    // Duplicate logic
    private function duplicateCheck($validator) {
        $data = SubcontItem::where('bp_code', Auth::user()->bp_code)
        ->where('item_code', $this->item_code)
        ->exists();

        $validator->after(function ($validator) use($data) {
            if ($data) {
                $validator->errors()->add('item_code', 'This item code already exist.');
            }
        });
    }
}

