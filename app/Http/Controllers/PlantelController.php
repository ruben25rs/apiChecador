<?php

namespace App\Http\Controllers;

use App\Models\Plantel;
use Illuminate\Http\Request;

class PlantelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plantel  $plantel
     * @return \Illuminate\Http\Response
     */
    public function getPlanteles()
    {
        //
        $planteles = Plantel::all();

        return response()->json($planteles);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plantel  $plantel
     * @return \Illuminate\Http\Response
     */
    public function edit(Plantel $plantel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plantel  $plantel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plantel $plantel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plantel  $plantel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plantel $plantel)
    {
        //
    }
}
