<?php

namespace App\Http\Requests\PasswordReset;

use Illuminate\Foundation\Http\FormRequest;

class VerifyPasswordResetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'code' => 'required|exists:verification_codes,code',
        ];
    }
}
