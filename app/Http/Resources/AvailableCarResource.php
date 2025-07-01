<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AvailableCarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'brand' => $this->brand,
            'model' => $this->model,
            'license_plate' => $this->license_plate,
            'year' => $this->year,
            'color' => $this->color,
            'notes' => $this->notes,
            'comfort_category' => [
                'id' => $this->comfortCategory->id,
                'name' => $this->comfortCategory->name,
                'level' => $this->comfortCategory->level,
                'description' => $this->comfortCategory->description,
            ],
            'driver' => [
                'id' => $this->driver->id,
                'full_name' => trim($this->driver->last_name . ' ' . $this->driver->first_name),
                'phone' => $this->driver->phone,
            ],
            'full_name' => $this->brand . ' ' . $this->model . ' (' . $this->license_plate . ')',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
