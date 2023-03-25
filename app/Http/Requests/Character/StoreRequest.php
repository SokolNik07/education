<?php

namespace App\Http\Requests\Character;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => ['required','string', 'min:3', 'max:30'],
            'age' => ['required', 'integer', 'min:14', 'max:100'],
            'biography' => ['required', 'string', 'min:25', 'max:255'],
            'obituary' => ['sometimes', 'string', 'min:25', 'max:255'],
            'status' => ['required', 'string'],
            'fraction_id' => ['required', 'integer'],
            'image' => ['sometimes', 'file', 'max:2048'],
        ];
    }
}
