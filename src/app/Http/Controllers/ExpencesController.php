<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpencesRequest;
use App\Http\Requests\UpdateExpencesRequest;
use App\Models\Expences;

class ExpencesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpencesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Expences $expences)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expences $expences)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpencesRequest $request, Expences $expences)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expences $expences)
    {
        //
    }
}
