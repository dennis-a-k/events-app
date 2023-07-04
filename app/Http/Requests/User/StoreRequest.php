<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'login'         => 'required|string|min:5|alpha_dash|unique:users,login',
            'password'      => 'required|string|min:8|confirmed',
            'name'          => 'required|string',
            'last_name'     => 'required|string',
            'birthday'      => 'nullable|date_format:format',
        ];
    }
}
