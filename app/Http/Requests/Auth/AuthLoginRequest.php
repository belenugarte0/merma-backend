<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email" => "required|email|exists:users,email",
            "password" => "required",
        ];
    }

    public function messages(): array
    {
        return [
            "email.required" => "El campo email es requerido",
            "email.email" => "Ingrese un correo valido",
            "email.exists" => "El correo electronico no se encontro",
            "password.required" => "El campo password es requerido",
        ];
    }

}
