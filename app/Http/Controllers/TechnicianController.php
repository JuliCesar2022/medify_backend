<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTechnicianRequest;
use App\Http\Requests\UpdateTechnicianRequest;
use App\Models\Technician;
use Illuminate\Http\Response;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTechnicianRequest $request
     * @return Response
     */
    public function store(StoreTechnicianRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Technician $technician
     * @return Response
     */
    public function show(Technician $technician)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateTechnicianRequest $request
     * @param Technician $technician
     * @return Response
     */
    public function update(UpdateTechnicianRequest $request, Technician $technician)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Technician $technician
     * @return Response
     */
    public function destroy(Technician $technician)
    {
        //
    }
}
