<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComputerRequest extends FormRequest
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
            "name" => ["required"],
            "ram" => ["required", "gt:0"],
            "computerNumber" => ["required", "integer", "unique:computers,computer_number"],
            "ports" => ["required", "array"],
            "ports.*.type" => ["required"],
            "ports.*.amount" => ["required", "integer"],
            "programs" => ["required", "array"],
            "programs.*" => ["required", "integer", "exists:programs,id"],
        ];
    }

    public function messages(): array {
        return [
            "name" => "El cpu del equipo es obligatorio",
            "ram" => "La ram del equipo es obligatoria",
            "computerNumber.required" => "El numero de equipo es obligatorio",
            "computerNumber.numeric" => "El numero de equipo debe ser numerico",
            "computerNumber.unique" => "El numero de equipo no debe repetirse",
            "ports" => "Debes agregar al menos un puerto",
            "programs" => "Debes agregar al menos un programa",
            "ports.*.type" => "El nombre del puerto es obligatorio",
            "ports.*.amount" => "La cantidad del puerto es obligatoria",
        ];
    }
}
