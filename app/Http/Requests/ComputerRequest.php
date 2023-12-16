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
            "dataComputer.ram" => ["required"],
            "dataComputer.ports" => ["required", "array"],
            "dataComputer.ports.*.name" => ["required"],
            "dataComputer.ports.*.amount" => ["required", "numeric"],
            "dataComputer.programs" => ["required", "array"],
            "dataComputer.programs.*" => ["required", "numeric", "exists:programs,id"],
        ];
    }
}
