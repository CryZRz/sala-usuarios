<?php

namespace App\Http\Requests;

use App\Http\Utils\CareersE;
use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            "controlNumber" => ["required", "unique:student_updates,controlNumber"],
            "lastName" => ["required"],
            "career" => [
                "required",
                "exists:careers,id",
            ],
            "curp" => ["required", "unique:students,curp"],
            "semester" => ["required", "numeric", "min:0", "max:13"]
        ];
    }

    public function messages() : array {
        return [
            "name" => "El nombre es obligatorio",
            "controlNumber" => "El numero es obligatorio y unico",
            "lastName" => "Los apellidos son obligatorios",
            "career" => "La carrera no es valida",
            "semester" => "El semestre debe estar entre 0 y 13",
        ];
    }
}
