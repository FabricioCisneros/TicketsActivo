<?php

namespace App\Http\Resources\Reporte;

use App\Http\Resources\Department\DepartmentSelectResource;
use App\Http\Resources\Ticket\TicketManageResource;
use App\Http\Resources\User\UserDetailsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReporteListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

     public function toArray($request)
     {
        $reporte=$this;

        return[
            'id'=>$reporte->id,
            'titulo'=>$reporte->tituloReporte,
            'razonReporte'=>$reporte->razon_reporte,
            'user'=>new UserDetailsResource($reporte->user),
            'agent'=>new UserDetailsResource($reporte->agent),
            'userReport'=>new UserDetailsResource($reporte->userReport),
            'department'=>new DepartmentSelectResource($reporte->department),
            'ticket'=>new TicketManageResource($reporte->ticket),
            'created_at' => $reporte->created_at->toISOString(),
            'updated_at' => $reporte->updated_at->toISOStri
        ];
     }
   
}
