<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Auth;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email" => "email|exists:users,email",
            'password' => ['required', function ($attr, $value, $fail) {
                $people = \App\Models\User::where('email', $this->request->get('email'))->first();
                if ($people && !(Hash::check($value, $people->password))) {
                    $fail($attr . ' tidak valid');
                }
            }],
        ];
    }
}
