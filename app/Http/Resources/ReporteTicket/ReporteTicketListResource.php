<?php

namespace App\Http\Resources\ReporteTicket;

use App\Http\Resources\Department\DepartmentSelectResource;
use App\Http\Resources\Ticket\TicketManageResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\UserDetailsResource;


class ReporteTicketListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $reportTicket=$this;

        return [
            'id'=>$reportTicket->id,
            'tituloReporte'=>$reportTicket->tituloReporte,
            'razonReporte'=>$reportTicket->razonReporte,
            'user'=>new UserDetailsResource($reportTicket->user),
            'agent'=>new UserDetailsResource($reportTicket->agent),
            'reportedBy' => new UserDetailsResource($reportTicket->reportedBy),            
            'department'=>new DepartmentSelectResource($reportTicket->department),
            'ticket'=>new TicketManageResource($reportTicket->ticket),
            'created_at' => $reportTicket->created_at->toISOString(),
            'updated_at' => $reportTicket->updated_at->toISOString()
        ];
    }
}
 