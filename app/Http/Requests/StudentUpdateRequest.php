<?php

namespace App\Http\Requests;

use App\Http\Utils\CareersE;
use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
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
        $student = $this->route("student");
        $controlNumber = $student->controlNumber;
 
        return [
            "name" => ["required"],
            "controlNumber" => ["required", "unique:students,controlNumber,$controlNumber,controlNumber"],
            "lastName" => ["required"],
            "career" => [
                "required",
                "in:".implode(",", CareersE::getCareers())
            ],
            "semester" => ["required", "numeric", "gt:0"]
        ];
    }

    public function messages() : array {
        return [
            "name" => "El nombre es obligatorio",
            "controlNumber" => "El numero de control no debe haberse registrado antes",
            "lastName" => "Los apellidos son obligatorios",
            "career" => "La carrera no es valida",
            "semester" => "el semestre no debe ser negativo"
        ];
    }
}
