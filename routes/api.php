<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\OptionalControoler;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthenticationController::class, 'login']);

//// Users
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user}', [UserController::class, 'show']);

/// Category
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']);

//// Meal
Route::get('/meals', [MealController::class, 'index']);
Route::get('/topMeals', [MealController::class, 'topMeals']);
Route::get('/getMealByCategoryId/{id}', [MealController::class, 'getMealByCategory']);
Route::get('/meals/{meal}', [MealController::class, 'show']);

/// Floors
Route::get('/floors', [FloorController::class, 'index']);
Route::get('/floors/{floor}', [FloorController::class, 'show']);

////  Table
Route::get('/tables', [TableController::class, 'index']);
Route::get('/tables/{table}', [TableController::class, 'show']);

/// Order
Route::post('/orders', [OrderController::class, 'store']);


Route::post('/logout', [AuthenticationController::class, 'logout']);
Route::middleware(['auth:sanctum'])->group(function () {
    /// Order
    Route::get('/statistics', [StatisticsController::class, 'index']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::patch('/acceptOrder/{order}', [OrderController::class, 'acceptOrder']);
    Route::patch('/rejectOrder/{order}', [OrderController::class, 'rejectOrder']);
    Route::patch('/order-to-casher/{order}', [OrderController::class, 'moveToCasher']);
    Route::delete('/orders/{order}', [OrderController::class, 'destroy']);
    Route::get('/kitchen-orders', [OrderController::class, 'kitchenOrders']);
    Route::get('/runner-orders', [OrderController::class, 'runnerOrders']);
    Route::get('/casher-orders', [OrderController::class, 'casherOrders']);

    /// User
    Route::patch('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
    Route::post('/users', [UserController::class, 'store']);

    //// Table
    Route::patch('/tables/{table}', [TableController::class, 'update']);
    Route::delete('/tables/{table}', [TableController::class, 'destroy']);
    Route::post('/tables', [TableController::class, 'store']);

    /// Floor
    Route::patch('/floors/{floor}', [FloorController::class, 'update']);
    Route::delete('/floors/{floor}', [FloorController::class, 'destroy']);
    Route::post('/floors', [FloorController::class, 'store']);

    //// Meal
    Route::post('/meals/{meal}', [MealController::class, 'update']);
    Route::delete('/meals/{meal}', [MealController::class, 'destroy']);
    Route::patch('/switch_meal/{meal}', [MealController::class, 'switchMeal']);
    Route::post('/meals', [MealController::class, 'store']);

    /// Category
    Route::post('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
    Route::post('/categories', [CategoryController::class, 'store']);

    /// Optional
    Route::post('/optionals', [OptionalControoler::class, 'store']);
    Route::delete('/optionals/{optional}', [OptionalControoler::class, 'delete']);
});
