<?php

namespace App\Http\Requests;

use App\Http\Utils\CareersE;
use Illuminate\Foundation\Http\FormRequest;

class StudentSearchRequest extends FormRequest
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
            "controlNumber" => ["required",  "exists:student_updates,controlNumber"]
        ];
    }

    public function messages() : array {
        return [
            "controlNumber" => "Este número de control no está registrado en el sistema, revisa que sea correcto.",
            "controlNumber.exists" => "El número de control no tiene ninguna incidencia registrada"
        ];
    }
}
