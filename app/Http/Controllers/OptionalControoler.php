<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOptionRequest;
use App\Http\Resources\OptionResource;
use App\Models\Optional;
use Illuminate\Http\Request;

class OptionalControoler extends Controller
{
    public function index()
    {
        $option = Optional::all();

        return OptionResource::collection($option);
    }

    public function store(StoreOptionRequest $request)
    {
        try {
            Optional::create($request->all());

            return response()->json([
                'message' => 'Created SuccessFully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete(Optional $optional){
        $optional->delete();
        return OptionResource::make($optional);
    }
}
