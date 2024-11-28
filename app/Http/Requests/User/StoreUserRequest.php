<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => 'required|unique:users|email',
            'name' => 'required|min:3',
            'lastname' => 'required|min:3',
            'document' => 'required|min:7',
            'role' => 'required'
        ];
    }


    public function messages(): array
    {
         return [
            'name.required' => 'Nombre es requerido',
            'name.min' => 'El nombre debe tener al menos 3 caracteres',
            'lastname.required' => 'Apellido es requerido',
            'lastname.min' => 'El Apellido debe tener al menos 3 caracteres',
            'document.required' => 'Cédula de Identidad es requerida',
            'document.min' => 'La Cédula de Identidad debe tener al menos 7 dígitos',
            'role.required' => 'Debe seleccionar al menos un Rol'
        ];
    }
}
