<?php

namespace App\Http\Controllers\Api\Asignacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Prioridad extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    
}
