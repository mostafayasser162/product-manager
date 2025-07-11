<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get paginated list of categories
        $categories = Category::paginate();

        // Transform categories using the resource
        $categories = CategoryResource::collection($categories);

        return response()->paginate_resource($categories);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        $category = Category::create($data);

        $category = new CategoryResource($category);

        return response()->success($category);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->errors('Category not found');
        }

        $category = new CategoryResource($category);

        return response()->success($category);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        $category->update($data);

        return response()->success(new CategoryResource($category));
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        // Find category by ID
        $category = Category::find($id);

        // Return error if category not found
        if (! $category) {
            return response()->errors('Category not found');
        }

        // Delete the category
        $category->delete();

        return response()->success('Category deleted successfully');
    }
}
