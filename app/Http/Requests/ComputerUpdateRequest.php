<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComputerUpdateRequest extends FormRequest
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
            "dataComputer.ram" => ["required"],
            "dataComputer.ports" => ["nullable", "array"],
            "dataComputer.ports.*.name" => ["required"],
            "dataComputer.ports.*.amount" => ["required", "numeric"],
            "dataComputer.programs" => ["nullable", "array"],
            "dataComputer.programs.*" => ["required", "numeric", "exists:programs,id"],
        ];
    }

    public function messages(): array {
        return [
            "dataComputer.name" => "El cpu del equipo es obligatorio",
            "dataComputer.ram" => "La ram del equipo es obligatoria",
            "dataComputer.ports.*.name" => "El nombre del puerto es obligatorio",
            "dataComputer.ports.*.amount" => "La cantidad del puerto es obligatoria",
        ];
    }
}
