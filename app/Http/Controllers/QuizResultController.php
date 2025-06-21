<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuizResult;
use App\Http\Resources\QuizResultResource;

class QuizResultController extends Controller
{
    public function index()
    {
        //$quizResults = QuizResult::with(['quiz', 'student'])->get();
        $quizResults = QuizResult::with(['quiz', 'student'])->paginate(3);
        return QuizResultResource::collection($quizResults);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'student_id' => 'required|exists:users,id',
            'score' => 'required|numeric',
        ]);

        $quizResult = QuizResult::create($data);

        return new QuizResultResource($quizResult);
    }

    public function show($id)
    {
        $quizResult = QuizResult::with(['quiz', 'student'])->findOrFail($id);
        return new QuizResultResource($quizResult);
    }

    public function update(Request $request, $id)
    {
        $quizResult = QuizResult::findOrFail($id);

        $data = $request->validate([
            'quiz_id' => 'sometimes|required|exists:quizzes,id',
            'student_id' => 'sometimes|required|exists:users,id',
            'score' => 'sometimes|required|numeric',
        ]);

        $quizResult->update($data);

        return new QuizResultResource($quizResult);
    }

    public function destroy($id)
    {
        $quizResult = QuizResult::findOrFail($id);
        $quizResult->delete();

        return response()->json(['message' => 'QuizResult deleted successfully.'], 200);
    }
}
