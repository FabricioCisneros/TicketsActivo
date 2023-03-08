<?php 

namespace App\Filters;

use EloquentFilter\ModelFilter;

class ReporteTicketFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];


    public function search($search):ReporteFilter
    {
        return $this->where('razonReporte', 'LIKE', '%'.$search.'%');
    }

    public function user($user):ReporteFilter{
        return $this->whereHas('user',function(Builder $query)use ($user){
            $query->where('name', 'LIKE', '%'.$user.'%')
                  ->orWhere('email', 'LIKE', '%'.$user.'%');
        });
    }

    public function userReport($userReport):ReporteFilter{
        return $this->WhereHas('user', function(Builder $query) use ($userReport){
            $query->where('name', 'LIKE', '%'.$userReport.'%')
                  ->orWhere('email', 'LIKE', '%'.$userReport.'%');
        });
    }

    public function agents($agents):ReporteFilter
    {
        return $this->whereIn('agent_id', $agents);
    }


    public function department($departments):ReporteFilter
    {
        return $this->where('department_id','=', $departments);
    }

    public function ticket($ticket):ReporteFilter
    {
        return $this->where('ticket_id', '=', $ticket);  
    }


}
