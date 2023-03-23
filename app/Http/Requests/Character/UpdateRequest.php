<?php

namespace App\Http\Requests\Character;

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
            'name' => ['sometimes','string', 'min:3', 'max:30'],
            'age' => ['sometimes', 'integer', 'min:14', 'max:100'],
            'biography' => ['sometimes', 'string', 'min:25', 'max:255'],
            'obituary' => ['sometimes', 'string', 'min:25', 'max:255'],
            'status' => ['sometimes', 'string'],
            'fraction_id' => ['sometimes', 'integer'],
            'profile_image' => ['sometimes', 'file', 'max:2048'],
        ];
    }
}
