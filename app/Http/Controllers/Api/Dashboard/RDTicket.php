<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Ticket\StoreRequest;
use App\Http\Resources\Reassigment\ReassigmentListResource;
use App\Http\Resources\Reassigment\ReassignmentResource;
use App\Models\Reasignacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class RDTicket extends Controller
{
   
    public function store(Request $request): JsonResponse
    {
        //$request->validated();
        $Reassignment = new Reasignacion;
        $Reassignment->source_department_id = $request->input('source_department_id');
        $Reassignment->destination_department_id = $request->input('destination_department_id');
        $Reassignment->ticket_id = $request->input('ticket_id');
        $Reassignment->reassigned_by_id = $request->input('reassigned_by_id');
        $Reassignment->lifted_by_id = $request->input('lifted_by_id');
        $Reassignment->description = $request->input('description');
        
        if ($Reassignment->save()) {
            return response()->json(['message' => __('Se reasigno el ticket'), 'user' => new ReassignmentResource($Reassignment)]);
        }
        return response()->json(['message' => __('Ocurrio un error al añadir al usuario')], 500);
    }

    public function index(Request $request): JsonResponse
    {
    
        $sort = json_decode($request->get('sort', json_encode(['order' => 'asc', 'column' => 'created_at'], JSON_THROW_ON_ERROR)), true, 512, JSON_THROW_ON_ERROR);
        
        $items = Reasignacion::filter()
        ->orderBy($sort['column'], $sort['order'])
        ->paginate((int) $request->get('perPage', 10));
        
        
        return response()->json([
            'items' => ReassigmentListResource::collection($items->items()),
            'pagination' => [
                'currentPage' => $items->currentPage(),
                'perPage' => $items->perPage(),
                'total' => $items->total(),
                'totalPages' => $items->lastPage()
            ]
        ]);

    }
}
