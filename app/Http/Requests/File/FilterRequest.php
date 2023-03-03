<?php

namespace App\Http\Requests\File;

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
            'filter' => ['sometimes', 'array'],
            'filter.*' => ['sometimes', 'array'],
            'filter.*.column' => ['sometimes', 'string', 'min:3','max:255'],
            'filter.*.operator' => ['sometimes', 'in:>,<,>=,<=,=,ilike,like' ],
            'filter.*.value' => ['sometimes'],
            'filter.*.boolean' => ['sometimes', 'string', 'in:and,or'],
            'page' => ['integer'],
            'per_page' => ['integer'],
        ];
    }
}
