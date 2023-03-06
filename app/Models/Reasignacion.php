<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use EloquentFilter\Filterable;

class Reasignacion extends Model
{
    use  HasFactory, Filterable;
    protected $table = 'reasignacion';
    protected $casts = [
        'source_department_id'=>'integer',
        'destination_department_id'=>'integer',
        'ticket_id'=>'integer',
        'reassigned_by_id'=>'integer',
        'lifted_by_id'=>'integer',
    ];

    public function sourceDepartment():BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function destinationDepartment():BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function ticket():BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function reassignedBy():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function liftedBy():BelongsTo
    {
        return $this->belongsTo(User::class);
    }




}
