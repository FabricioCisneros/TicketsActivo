<?php

namespace App\Http\Resources\ReporteTicket;

use Illuminate\Http\Resources\Json\JsonResource;

class ReporteTicketManageResource extends JsonResource
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

       return[
        'id'=>$reportTicket->id,
        'uuid'=>$reportTicket->uuid,
        'razonReporte'=>$reportTicket->razonReporte,
        'titulo'
       ];
    }
}
