<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parents = Category::whereNull('parent_id')->get();
        $categories = Category::whereNull('parent_id')->with('childrens')->withCount('childrens')->get();
        return view('dashboard.categories.index', compact('parents', 'categories'));
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        Category::create($request->all());
        return redirect()->route('dashboard.categories.index')->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255',  "unique:categories,name,$category->id"],
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category->update($request->all());

        return redirect()->route('dashboard.categories.index')->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->childrens->count() > 0) {
            return redirect()->route('dashboard.categories.index')->with('error', 'Category has childrens');
        }
        $category->delete();
        return redirect()->route('dashboard.categories.index')->with('success', 'Category deleted successfully');
    }


    public function toggleActive(Category $category)
    {
        $category->update([
            'active' => !$category->active
        ]);
        return redirect()->route('dashboard.categories.index')->with('success', 'Category updated successfully');
    }
}
