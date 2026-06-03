<?php

namespace App\Http\Requests\Admin;

use App\Support\MaterialIcons;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCoachingProgramRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'icon' => ['required', 'string', Rule::in(MaterialIcons::names())],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'is_active' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
