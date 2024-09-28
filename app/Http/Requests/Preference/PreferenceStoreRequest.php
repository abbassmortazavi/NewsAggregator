<?php

namespace App\Http\Requests\Preference;

use Illuminate\Foundation\Http\FormRequest;

class PreferenceStoreRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'sources' => 'nullable|array',
            'categories' => 'nullable|array',
            'authors' => 'nullable|array',
        ];
    }
}
