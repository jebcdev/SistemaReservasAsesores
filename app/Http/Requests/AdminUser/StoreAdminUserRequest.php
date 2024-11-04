<?php

namespace App\Http\Requests\AdminUser;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAdminUserRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check() && Auth::user()->role_id==1; // Cambia esto según tu lógica de autorización
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone' => 'required|string|max:200',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'role_id' => 'required|exists:roles,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('Name is required.'),
            'lastname.required' => __('Lastname is required.'),
            'phone.required' => __('Phone is required.'),
            'email.required' => __('Email is required.'),
            'password.required' => __('Password is required.'),
            'role_id.required' => __('Role is required.'),
            // Otros mensajes personalizados
        ];
    }
}
