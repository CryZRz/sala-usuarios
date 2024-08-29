<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "career" => $this->career,
            "controlNumber" => $this->controlNumber,
            "created_at" => $this->created_at,
            "id" => $this->id,
            "period" => $this->period,
            "semester" => $this->semester,
            "student" => $this->student
        ];
    }
}
