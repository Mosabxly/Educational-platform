<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Quizz;
use App\Http\Resources\QuizzResource;

class QuizzController extends Controller
{
    public function index()
    {
        //$quizzes = Quizz::with(['course', 'results'])->get();
        $quizzes = Quizz::with(['course', 'results'])->paginate(3);
        return QuizzResource::collection($quizzes);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
        ]);

        $quiz = Quizz::create($data);

        return new QuizzResource($quiz);
    }

    public function show($id)
    {
        $quiz = Quizz::with(['course', 'results'])->findOrFail($id);
        return new QuizzResource($quiz);
    }

    public function update(Request $request, $id)
    {
        $quiz = Quizz::findOrFail($id);

        $data = $request->validate([
            'course_id' => 'sometimes|required|exists:courses,id',
            'title' => 'sometimes|required|string|max:255',
        ]);

        $quiz->update($data);

        return new QuizzResource($quiz);
    }

    public function destroy($id)
    {
        $quiz = Quizz::findOrFail($id);
        $quiz->delete();

        return response()->json(['message' => 'Quiz deleted successfully.'], 200);
    }
}
