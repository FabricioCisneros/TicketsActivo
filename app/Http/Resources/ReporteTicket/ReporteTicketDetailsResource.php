<?php

namespace App\Http\Resources\ReporteTicket;

use App\Http\Resources\Ticket\TicketManageResource;
use App\Http\Resources\User\UserDetailsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReporteTicketDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $report=$this;
        return[
            'id'=>$report->id,
            'uuid'=>$report->uuid,
            'tituloReporte'=>$report->tituloReporte,
            'razonReporte'=>$report->razonReporte,
            'user'=>new UserDetailsResource($report->user),
            'user_id'=>$report->user_id,
            'reportedBy'=>new UserDetailsResource($report->reportedBy),
            'reportedBy_id'=>$report->reportedBy_id,
            'ticket_id'=>$report->ticket_id,
            'ticket'=>new TicketManageResource($report->ticket),
            'agent'=>new UserDetailsResource($report->agent),
            'agent_id'=>$report->agent_id,
        ];
    }
}
