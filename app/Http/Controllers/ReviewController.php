<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Review;
use App\Http\Resources\ReviewResource;

class ReviewController extends Controller
{
     public function index()
    {
        //$reviews = Review::with(['course', 'student'])->get();
        $reviews = Review::with(['course', 'student'])->paginate(3);
        return ReviewResource::collection($reviews);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'student_id' => 'required|exists:users,id',
            'rating' => 'nullable|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $review = Review::create($data);

        return new ReviewResource($review);
    }

    public function show($id)
    {
        $review = Review::with(['course', 'student'])->findOrFail($id);
        return new ReviewResource($review);
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $data = $request->validate([
            'course_id' => 'sometimes|required|exists:courses,id',
            'student_id' => 'sometimes|required|exists:users,id',
            'rating' => 'sometimes|nullable|integer|min:1|max:5',
            'comment' => 'sometimes|nullable|string',
        ]);

        $review->update($data);

        return new ReviewResource($review);
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return response()->json(['message' => 'Review deleted successfully.'], 200);
    }
}
