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

    public function update(UpdateFAQRequest $request, $Id)
    {
        try {
            $option = Optional::find($Id);
            if (! $option) {
                return response()->json(['message' => 'Not Found'], 404);
            }
            $option->update($request->all());

            return response()->json([
                'message' => 'Updated SuccessFully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($Id)
    {
        $option = Option::find($Id);
        if (! $option) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return OptionResource::make($option);
    }

    public function delete($Id)
    {
        try {
            $option = Option::find($Id);
            if (! $option) {
                return response()->json(['message' => 'Not Found'], 404);
            }
            $option->delete();

            return response()->json([
                'message' => 'Deleted SuccessFully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
