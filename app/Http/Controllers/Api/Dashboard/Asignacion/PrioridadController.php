<?php

namespace App\Http\Controllers\Api\Asignacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrioridadController extends Controller
{
    public function store(StoreRequest $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  Label  $label
     * @return JsonResponse
     */
    public function show(Label $label){
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  Label  $label
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Label $label){
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Label  $label
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Label $label)
    {

    }
}
