<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AsignUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
}
