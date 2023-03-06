<?php

namespace App\Filters;

use EloquentFilter\ModelFilter;
use Iluminate\Database\Eloquent\Builder;

class ReasignacionFilter extends ModelFilter{

    public $relations=[];

    public function search($search):ReasignacionFilter
    {
        return $this->where('description','LIKE','%'.$search.'%');
    }
    
    public function reassignedBy($reassigned_by):ReasignacionFilter
    {
        return $this->whereHas('user',function(Builder $query) use ($reassigned_by){
            $query->where('name', 'LIKE', '%'.$reassigned_by.'%')
                  ->orWhere('email','LIKE', '%'.$reassigned_by.'%');
        });
    }

    public function liftedBy($lifted_by):ReasignacionFilter
    {
        return $this->whereHas('user',function(Builder $query) use ($lifted_by){
            $query->where('name', 'LIKE', '%'.$lifted_by.'%')
                  ->orWhere('email','LIKE', '%'.$lifted_by.'%');
        });
    }

    public function ticket($ticket):ReasignacionFilter
    {
        return $this->where('ticket_id', '=', $ticket);
    }

    public function sourceDepartment($sourceDepartment):ReasignacionFilter
    {
        return $this->where('source_department', '=', $sourceDepartment);
    }

    public function destinationDepartment($destinationDepartment):ReasignacionFilter
    {
        return $this->where('destination_department', '=', $destinationDepartment);
    }

}