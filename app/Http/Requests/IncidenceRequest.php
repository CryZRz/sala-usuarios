<?php

namespace App\Http\Requests;

use App\Http\Utils\CareersE;
use Illuminate\Foundation\Http\FormRequest;

class IncidenceRequest extends FormRequest
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
            "controlNumber" => ["required", "exists:student_updates,controlNumber"],
            "descripción" => ["required"]
        ];
    }

    public function messages(): array
    {
        return [
            "controlNumber:required" => "El numero de control es obligatorio",
            "controlNumber:exists" => "Alumno no registrado; si lo ingresaste correctamente, continúa: ",
            "descripción:required" => "La descripción es obligatoria."
        ];
    }
}
