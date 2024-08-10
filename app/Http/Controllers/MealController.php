<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMealRequest;
use App\Http\Requests\UpdateMealRequest;
use App\Http\Resources\MealResource;
use App\HttpResponse\CustomResponse;
use App\Models\Category;
use App\Models\Meal;
use App\SecurityChecker\Checker;

class MealController extends Controller
{
    use Checker;
    use CustomResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $meals = Meal::all();

            return MealResource::collection($meals);
    }

    public function getMealByCategory($category)
    {
        $meal = Meal::where('category_id', $category)->get();

        return MealResource::collection($meal);
    }

    public function topMeals()
    {
        $meals = Meal::limit(2)->get();

        return MealResource::collection($meals);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(StoreMealRequest $request)
    {
        try {
            $meal = Meal::create($request->all());

            return response()->json([
                'message' => 'Created SuccessFully',
                'data' => MealResource::make($meal),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Meal $meal)
    {
        if ($this->isExtraFoundInBody([])) {
            return $this->ExtraResponse();
        }
        if ($this->isParamsFoundInRequest()) {
            return $this->CheckerResponse();
        }
        try {
            return MealResource::make($meal);
        } catch (\Throwable $th) {
            return $this->error($meal, $th->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMealRequest $request, Meal $meal)
    {
        $request->validated($request->all());
        $meal->update($request->all());
        return MealResource::make($meal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meal $meal)
    {
        $meal->delete();
        return MealResource::make($meal);
    }

    public function switchMeal(Meal $meal)
    {
        $meal->update([
            'visible' => ! $meal->visible,
        ]);

        return MealResource::make($meal);
    }
}
