<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReporteTicket extends Model
{
    use HasFactory, Filterable;

    protected $table='reporteticket';

    protected $casts=[
        'user_id'=>'integer', 
        'agent_id'=>'integer',
        'reportedBy_id'=>'integer',
        'department_id'=>'integer',
        'ticket_id'=>'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function user():BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }

    public function agent():BelongsTo{
        return $this->belongsTo(User::class,'agent_id');
    }
    public function reportedBy():BelongsTo{
        return $this->belongsTo(User::class, 'reportedBy_id');
    }
    public function department():BelongsTo{
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function ticket():BelongsTo{
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }



}
