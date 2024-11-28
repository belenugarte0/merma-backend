<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|unique:users|email', 
            'name' => 'required|min:3',
            'lastname' => 'required|min:3',
            'document' => 'required|min:7',
        ];
    }
    public function messages(): array
    {
        return [
            'email.required' => 'Email es requerido',
            'email.unique' => 'Email ya Existe',
            'name.required' => 'Nombre es requerido',
            'name.min' => 'El nombre debe tener al menos 2 caracteres',
            'lastname.required' => 'Apellido es requerido',
            'lastname.min' => 'El Apellido debe tener al menos 2 caracteres',
            'document.required' => 'Cedua Identidad es requerido',
            'document.min' => 'La Cedua Identidad debe tener al menos 7 digitos',
        ];
    }
}
