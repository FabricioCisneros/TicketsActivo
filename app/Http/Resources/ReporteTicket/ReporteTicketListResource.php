<?php

namespace App\Http\Resources\ReporteTicket;

use App\Http\Resources\Department\DepartmentSelectResource;
use App\Http\Resources\Ticket\TicketManageResource;
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
            'user'=>new userDetailsResource($reportTicket->user),
            'agent'=>new userDetailsResource($reportTicket->agent),
            'userReport'=>new userDetailsResource($reportTicket->userReport),
            'department'=>new DepartmentSelectResource($reportTicket->department),
            'ticket'=>new TicketManageResource($reportTicket->ticket),
            'created_at' => $reportTicket->created_at->toISOString(),
            'updated_at' => $reportTicket->updated_at->toISOString()
        ];
    }
}
 