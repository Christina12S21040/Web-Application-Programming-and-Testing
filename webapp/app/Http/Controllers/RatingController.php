<?php

namespace App\Http\Controllers;

use App\Http\Resources\RatingResource;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    public function index(): JsonResponse
    {
        $ratings = Rating::all();
        $formattedRatings = $ratings->map(function ($rating) {
            return [
                'rating' => $rating,
                'links' => $rating->getLinks(),
            ];
        });

        return response()->json([
            'ratings' => $formattedRatings,
        ]);
    }

    public function show($id)
    {
        $rating = Rating::findOrFail($id);
        return response()->json([
            'rating' => $rating,
            'links' => $rating->getLinks(),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_item_id' => '',
            'product_rate' => 'required',
            'type' => '',
            'description' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $rating = Rating::create($request->all());
        return new RatingResource($rating);
    }

    public function update(Request $request, $id)
    {
        $rating = Rating::find($id);

        if (!$rating) {
            return response()->json(['error' => 'Rating not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'order_item_id' => '',
            'product_rate' => 'required',
            'type' => '',
            'description' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $rating->update($request->all());
        return new RatingResource($rating);
    }

    public function destroy($id)
    {
        $rating = Rating::find($id);

        if (!$rating) {
            return response()->json(['error' => 'Rating not found'], 404);
        } else {
            $rating->delete();
            return response()->json(['message' => 'Rating deleted successfully']);
        }
    }
}
