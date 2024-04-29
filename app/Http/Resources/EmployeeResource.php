<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'city' => $this->city->name,
            'state' => $this->state->name,
            'country' => $this->country->name,
            'department' => $this->department->name,
            'address' => $this->address,
            'zip_code' => $this->zip_code,
            'birth_date' => $this->birth_date,
            'date_hired' => $this->date_hired,
        ];
    }
}
