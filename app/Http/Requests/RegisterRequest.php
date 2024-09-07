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
            "email" => ["required", "email", "unique:users,email"],
            "pass" => ["required", "min:4"],
            "confirm-password" => ["required", "min:4", "same:pass"],
            "name" => ["required", "min:3"]
        ];
    }

    public function messages(): array
    {
        return [
            "email.required" => "Ingresa el correo electrónico ",
            "email.email" => "El correo electrónico no es válido.",
            "email.unique" => "El correo electrónico ya está registrado para otra cuenta",

            "name.required" => "Ingresa el nombre.",
            "name.min" => "Asegurate que el nombre tenga 3 o más caracteres.",

            "pass.required" => "Ingresa la contraseña",
            "pass.min" => "Asegurate que la contraseña tenga 4 o más caracteres.",

            "confirm-password.required" => "Repite la contraseña.",
            "confirm-password.min" => "Asegurate que la contraseña tenga 4 o más caracteres.",
            "confirm-password.same" => "La contraseña no es la misma en ambos campos."
        ];
    }
}
