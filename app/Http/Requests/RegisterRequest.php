<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
    ];
}
    public function messages(): array
{
    return [
        'email.required' => 'Veuillez entrer un email.',
        'email.unique' => 'Cet email est déjà utilisé.',
        'password.confirmed' => 'Les mots de passe ne correspondent pas.',
    ];
}
}
