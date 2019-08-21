<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CategoryResource;

class TicketExportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'ticket_id' => "$this->ticket_id",
            'department' => $this->department->name,
            'unit' => $this->unit->name,
            'category' => $this->category->name,
            'issue' => $this->title,
            'details' => $this->message,
            'created_by' => $this->user->name,
            'is_assigned' => $this->is_assigned ? 'Assigned' : 'Not yet assigned',
            'assigned_to' => $this->is_assigned ? $this->assignedTo->name : '-',
            'created_at' => $this->formated_date,
            'updated_at' => $this->formatDate($this->updated_at),

        ];
    }
}
