<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\HttpResponse\CustomResponse;
use App\Models\Category;
use App\SecurityChecker\Checker;

class CategoryController extends Controller
{
    use Checker;
    use CustomResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $meals = Category::all();

        return CategoryResource::collection($meals);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $request->validated();

        $meal = Category::create($request->all());

        return CategoryResource::make($meal);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        if ($this->isExtraFoundInBody([])) {
            return $this->ExtraResponse();
        }
        if ($this->isParamsFoundInRequest()) {
            return $this->CheckerResponse();
        }
        try {
            return CategoryResource::make($category);
        } catch (\Throwable $th) {
            return $this->error($category, $th->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $category->update($request->all());

            return CategoryResource::make($category);
        } catch (\Throwable $th) {
            return $this->error($category, $th->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($this->isExtraFoundInBody([])) {
            return $this->ExtraResponse();
        }
        if ($this->isParamsFoundInRequest()) {
            return $this->CheckerResponse();
        }
        try {
            $category->delete();
        } catch (\Throwable $th) {
            return $this->error($category, $th->getMessage(), 500);
        }
    }
}
