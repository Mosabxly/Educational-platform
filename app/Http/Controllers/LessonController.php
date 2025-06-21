<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Http\Resources\LessonResource;

class LessonController extends Controller
{
      public function index()
    {
        //$lessons = Lesson::with(['course'])->get();
        $lessons = Lesson::with(['course'])->paginate(3);
        return LessonResource::collection($lessons);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'content' => 'required|string',
            'order' => 'required|integer',
        ]);

        $lesson = Lesson::create($data);

        return new LessonResource($lesson);
    }

    public function show($id)
    {
        $lesson = Lesson::with(['course'])->findOrFail($id);
        return new LessonResource($lesson);
    }

    public function update(Request $request, $id)
    {
        $lesson = Lesson::findOrFail($id);

        $data = $request->validate([
            'course_id' => 'sometimes|required|exists:courses,id',
            'content' => 'sometimes|required|string',
            'order' => 'sometimes|required|integer',
        ]);

        $lesson->update($data);

        return new LessonResource($lesson);
    }

    public function destroy($id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();

        return response()->json(['message' => 'Lesson deleted successfully.'], 200);
    }
}
