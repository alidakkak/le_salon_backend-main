<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Meal;
use App\Models\Order;
use App\Models\Table;

class StatisticsController extends Controller
{
    public function index()
    {
        $tables = Table::count();
        $meals = Meal::count();
        $categories = Category::count();
        $seals = Order::sum('total');

        return response([
            'tables' => $tables,
            'meals' => $meals,
            'categories' => $categories,
            'seals' => $seals,
        ], 200);
    }
}
