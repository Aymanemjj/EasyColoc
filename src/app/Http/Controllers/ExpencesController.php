<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExpencesRequest;
use App\Http\Requests\UpdateExpencesRequest;
use App\Models\Category;
use App\Models\Expences;
use App\Models\House;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
    public function create($id)
    {
        
        $house = House::find($id);
        return view('expenceCreate', compact('house'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpencesRequest $request, $id)
    {
        $validated = $request->validated();
        $validated['date'] = substr($validated['date'], 0, 7);

        if (!Category::where('id', $validated['category_id'])->where('house_id', $id)->exists()) {

            throw ValidationException::withMessages([
                'expense_category_id' => trans("Category doesn't exist"),
            ]);
        }

        Expences::create([
            'title' => $validated['title'],
            'amount' => $validated['amount'],
            'date' => $validated['date'],
            'user_id' => $validated['user_id'],
            'house_id' => $id,
            'category_id' => $validated['category_id']
        ]);
        return redirect()->route('house.show', $id);
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
    public function edit($id)
    {
        $expence = Expences::find($id);
        $house = House::find($expence->house_id);
        $categories = Category::where('house_id', $id)->where('id', '<>', $expence->category_id)->get();
        return view('expenceEdit', compact('house', 'categories', 'expence'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpencesRequest $request, $id)
    {
        $validated = $request->validated();
        $expence = Expences::find($id);
        $expence->update($validated);
        return redirect()->route('house.show', $expence->house_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $expence = Expences::find($id);
        $expence->delete();
        return redirect()->back();
    }
}
