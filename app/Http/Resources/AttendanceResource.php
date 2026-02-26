<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'employee_id' => $this->employee_id,
            'date' => $this->date->toDateString(),
            'check_in' => $this->check_in->format('H:i:s'),
            'check_out' => $this->check_out ? $this->check_out->format('H:i:s') : null,
            'device_id' => $this->device_id,
            'check_in_method' => $this->check_in_method->value,
            'check_out_method' => $this->check_out_method->value,
            'status' => $this->status->value,
            'approval_status' => $this->approval_status->value,
            'is_locked' => $this->is_locked,
            'locked_by' => $this->locked_by,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'deleted_at' => $this->deleted_at ? $this->deleted_at->toDateTimeString() : null,
        ];
    }
}
