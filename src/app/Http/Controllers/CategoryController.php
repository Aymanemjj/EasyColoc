<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\House;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $house = House::find($id);

        Gate::authorize('createCategory', [Category::class, $house]);
        
        return view('categoryCreate', compact('house'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request, $id)
    {
        $validated = $request->validated();
        Category::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'house_id' => $id
        ]);

        return redirect()->route('house.show', $id)
            ->withErrors([
                'type' => 1,
                'general' => "Category created"
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $house = House::find($category->house_id);

        Gate::authorize('update', $category);

        return view('categoryEdit', compact('house', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $validated = $request->validated();
        $category =  Category::find($id);
        $category->update($validated);
        return redirect()->route('house.show', $category->house_id)
            ->withErrors([
                'type' => 1,
                'general' => "Category edited"
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        Gate::authorize('delete', $category);


        if ($category->deletable()) {
            $category->delete();
            return redirect()->back()
                ->withErrors([
                    'type' => 1,
                    'general' => "Category deleted"
                ]);;
        } else {
            return redirect()->back()
                ->withErrors([
                    'type' => 0,
                    'general' => "You can't delete categories which have a linked payment to them"
                ]);;
        }
    }
}
