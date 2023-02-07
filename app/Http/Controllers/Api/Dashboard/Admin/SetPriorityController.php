<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Label\LabelResource;
use Illuminate\Http\Request;

class SetPriorityontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

   
}
