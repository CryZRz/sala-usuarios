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
            "dataComputer.name" => ["required"],
            "dataComputer.ram" => ["required", "gt:0"],
            "dataComputer.computerNumber" => ["required", "numeric", "unique:computers,computer_number"],
            "dataComputer.ports" => ["required", "array"],
            "dataComputer.ports.*.name" => ["required"],
            "dataComputer.ports.*.amount" => ["required", "numeric"],
            "dataComputer.programs" => ["required", "array"],
            "dataComputer.programs.*" => ["required", "numeric", "exists:programs,id"],
        ];
    }

    public function messages(): array {
        return [
            "dataComputer.name" => "El cpu del equipo es obligatorio",
            "dataComputer.ram" => "La ram del equipo es obligatoria",
            "dataComputer.computerNumber.required" => "El numero de equipo es obligatorio",
            "dataComputer.computerNumber.numeric" => "El numero de equipo debe ser numerico",
            "dataComputer.computerNumber.unique" => "El numero de equipo no debe repetirse",
            "dataComputer.ports" => "Debes agregar al menos un puerto",
            "dataComputer.programs" => "Debes agregar al menos un programa",
            "dataComputer.ports.*.name" => "El nombre del puerto es obligatorio",
            "dataComputer.ports.*.amount" => "La cantidad del puerto es obligatoria",
        ];
    }
}
