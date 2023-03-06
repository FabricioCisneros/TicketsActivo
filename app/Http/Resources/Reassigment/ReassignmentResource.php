<?php

namespace App\Http\Resources\Reassigment;

use Illuminate\Http\Resources\Json\JsonResource;

class ReassignmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $reassignment=$this;
        return[
            
            'id'=>$reassignment->id,
            'source_department_id'=>$reassignment->source_department_id,
            'destination_department_id'=>$reassignment->destination_department_id,
            'ticket_id'=>$reassignment->ticket_id,
            'reassigned_by_id'=>$reassignment->reassigned_by_id,
            'lifted_by_id'=>$reassignment->lifted_by_id,
            'reason'=>$reassignment->description,
            'created_at' => $reassignment->created_at->toISOString(),
            'updated_at' => $reassignment->updated_at->toISOString()
            ];

    }
}
