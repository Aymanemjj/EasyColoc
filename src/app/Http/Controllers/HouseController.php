<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHouseRequest;
use App\Http\Requests\UpdateHouseRequest;
use App\Models\House;
use Illuminate\Support\Facades\Auth;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($house)
    {
        dd($house);
        return view('house');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('houseCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHouseRequest $request)
    {
        $validated = $request->validated();
        House::create([
            'title' => $validated['title'],
            'description' => $validated['description']
        ])->user()->attach(Auth::user(),['is_owner'=>1]);
        
        return redirect()->route('house.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(House $house)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(House $house)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHouseRequest $request, House $house)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(House $house)
    {
        //
    }
}
