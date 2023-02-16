<?php

namespace App\Http\Requests\Video;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
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
            'id' => ['sometimes', 'integer'],
            'user_id' => ['sometimes', 'integer'],
            'name' => ['sometimes', 'string', 'min:3','max:30'],
            'url' => ['sometimes', 'url'],
            'page' => ['integer'],
            'per_page' => ['integer'],
        ];
    }
}
