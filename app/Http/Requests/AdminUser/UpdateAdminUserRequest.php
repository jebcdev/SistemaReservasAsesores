<?php

namespace App\Http\Requests\AdminUser;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateAdminUserRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check() && Auth::user()->role_id == 1; // Cambia esto según tu lógica de autorización
    }

    public function rules()
    {
        $userId = $this->route('user'); // Obtener el ID del usuario en la ruta

        return [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:200'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId)
            ],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'role_id' => ['required', 'exists:roles,id'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('Name is required.'),
            'lastname.required' => __('Lastname is required.'),
            'phone.required' => __('Phone is required.'),
            'email.required' => __('Email is required.'),
            'role_id.required' => __('Role is required.'),
            // Otros mensajes personalizados
        ];
    }
}
