<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHouseRequest;
use App\Http\Requests\UpdateHouseRequest;
use App\Models\Category;
use App\Models\Expences;
use App\Models\House;
use Illuminate\Support\Facades\Auth;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

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
        ])->user()->attach(Auth::user(), ['is_owner' => 1]);

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $house = House::find($id);
        $categories = Category::where('house_id', $id)->get();
        $expences = Expences::where('house_id', $id)->get();
        return view('house', compact('house', 'categories', 'expences'));
    }

    public function exit($id)
    {
        $house = House::find($id);

        foreach ($house->user as $user) {
            if ($user->id === auth()->user()->id) $user->pivot->delete();
        }
        
        return redirect()->route('dashboard');
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
    public function destroy($id)
    {
        $house = House::find($id);
        $house ->status = false;
        $house->delete();
        return redirect()->route('dashboard');
    }
}
