<?php

namespace App\Http\Controllers\Api\Dashboard\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Reassigment\ReassigmentListResource;
use App\Http\Resources\Reassigment\ReassignmentResource;
use App\Http\Resources\Reporte\ReporteListResource;
use App\Http\Resources\ReporteTicket\ReporteTicketListResource;
use App\Http\Resources\Ticket\TicketListResource;
use App\Models\Reasignacion;
use App\Models\ReporteTicket;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;
use Str;
class ReportTicketController extends Controller
{
    public function store(Request $request):JsonResponse{
        $Report=new ReporteTicket;

        $Report->uuid = Str::uuid();
        $Report->user_id=$request->input('user_id');
        $Report->agent_id=$request->input('agent_id');
        $Report->reportedBy_id=$request->input('reportedBy_id');
        $Report->ticket_id=$request->input('ticket_id');
        $Report->department_id=$request->input('department_id');
        $Report->tituloReporte=$request->input('tituloReporte');
        $Report->razonReporte=$request->input('razonReporte');

        if($Report->save()){
            return response()->json(['message' => __('Se reasigno el ticket'), 'user' => new ReassignmentResource($Report)]);
        }
        return response()->json(['message' => __('Ocurrio un error al añadir al usuario')], 500);

    }


    public function index(Request $request):JsonResponse{
        $sort = json_decode($request->get('sort', json_encode(['order' => 'asc', 'column' => 'created_at'], JSON_THROW_ON_ERROR)), true, 512, JSON_THROW_ON_ERROR);
        
        $items = ReporteTicket::filter($request->all())
        ->orderBy($sort['column'], $sort['order'])
        ->paginate((int) $request->get('perPage', 10));
        
        return response()->json([
            'items' => ReporteTicketListResource::collection($items->items()),
            'pagination' => [
                'currentPage' => $items->currentPage(),
                'perPage' => $items->perPage(),
                'total' => $items->total(),
                'totalPages' => $items->lastPage()
            ]
        ]);
    }

    public function show(ReporteTicket $reporteTicket): JsonResponse
    {
        if ($reporteTicket->user_id !== Auth::id()) {
            return response()->json(['message' => __('Not found')], 404);
        }
        return response()->json(new TicketDetailsResource($reporteTicket)); 
    }
}
