<?php

namespace App\Http\Requests\Fraction;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['sometimes','string', 'min:3', 'max:30'],
            'description' => ['sometimes','string', 'min:3', 'max:30'],
            'banner' => ['sometimes', 'file', 'max:2048'],
        ];
    }
}
