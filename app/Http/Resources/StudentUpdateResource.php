<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentUpdateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "student" => [
                ...((new StudentResource($this->student))->toArray($request)),
                "controlNumber" => $this->controlNumber,
                "career" => $this->career,
                "semester" => $this->semester,
            ],
            "period" => new PeriodResource($this->period),
        ];
    }
}
