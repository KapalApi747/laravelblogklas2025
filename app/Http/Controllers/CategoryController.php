<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryController extends Controller
{
<<<<<<< HEAD
    use AuthorizesRequests, SoftDeletes; // Trait
=======
    use AuthorizesRequests; // Trait
>>>>>>> larastan

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('posts')->withTrashed()->paginate(3);

        return view('backend.categories.index', compact('categories'));
<<<<<<< HEAD
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('backend.categories.create');
=======
>>>>>>> larastan
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        //
<<<<<<< HEAD
        Category::create([$request->validated()]);

        return redirect()->route('categories.index')->with('message', 'Category created successfully!');
=======
        Category::create($request->validated());

        return redirect()->route('categories.index')->with('message', 'Category created successfully!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('backend.categories.create');
>>>>>>> larastan
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
    public function edit(Category $category)
    {
        //
        return view('backend.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        //
        $this->authorize('update', $category);
<<<<<<< HEAD
        Category::update([$request->validated()]);
=======
        $category->update($request->validated());
>>>>>>> larastan

        return redirect()->route('categories.index')->with('message', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        $this->authorize('delete', $category);
        $category->delete();

        return back()->with('message', 'Category deleted successfully!');
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $this->authorize('restore', $category);

        $category->restore();

        return back()->with('message', 'Category restored successfully!');
    }

    public function forceDelete($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $category);
        if ($category->posts()->exists()) {
            return back()->with('message', 'Category has posts, cannot delete!');
        }
        $category->forceDelete();

        return back()->with('message', 'Category deleted permanently!');
    }
}
