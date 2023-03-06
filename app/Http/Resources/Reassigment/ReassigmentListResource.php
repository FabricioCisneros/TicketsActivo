<?php

namespace App\Http\Resources\Reassigment;

use App\Http\Resources\Department\DepartmentSelectResource;
use App\Http\Resources\Ticket\TicketManageResource;
use App\Http\Resources\User\UserDetailsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReassigmentListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $reassignation=$this;

        return[
        'id'=>$reassignation->id,
        'description'=>$reassignation->description,
        'sourceDepartmen'=>new DepartmentSelectResource($reassignation->sourceDepartment),
        'destinationDepartment'=>new DepartmentSelectResource($reassignation->destinationDepartment),
        'ticket'=>new TicketManageResource($reassignation->ticket),
        'reassignedBy'=>new UserDetailsResource($reassignation->reassignedBy),
        'liftedBy'=>new UserDetailsResource($reassignation->liftedBy),
        'created_at' => $reassignation->created_at->toISOString(),
        'updated_at' => $reassignation->updated_at->toISOString()
        ];
    }
}
