<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Http\Resources\CourseResource;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index()
    {
        //$courses = Course::with(['instructor', 'category', 'enrollments', 'lessons', 'reviews', 'quizzes', 'certificates', 'payments'])->get();
        $courses = Course::with(['instructor', 'category', 'enrollments', 'lessons', 'reviews', 'quizzes', 'certificates', 'payments'])->paginate(3);
        return CourseResource::collection($courses);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'level' => 'required|in:beginner,intermediate,advanced',
            'category_id' => 'required|exists:categories,id',
            'instructor_id' => 'required|exists:users,id',
            'start_at' => 'required|date',
            'end_at' => 'required|date',
            'address' => 'nullable|string',
            'course_status' => 'required|in:paid,free',
            'price' => 'nullable|integer',
        ]);

        $course = Course::create($data);

        return new CourseResource($course);
    }

    public function show($id)
    {
        $course = Course::with(['instructor', 'category', 'enrollments', 'lessons', 'reviews', 'quizzes', 'certificates', 'payments'])->findOrFail($id);
        return new CourseResource($course);
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes|required|string|max:100',
            'description' => 'sometimes|nullable|string',
            'level' => 'sometimes|required|in:beginner,intermediate,advanced',
            'category_id' => 'sometimes|required|exists:categories,id',
            'instructor_id' => 'sometimes|required|exists:users,id',
            'start_at' => 'sometimes|required|date',
            'end_at' => 'sometimes|required|date',
            'address' => 'sometimes|nullable|string',
            'course_status' => 'sometimes|required|in:paid,free',
            'price' => 'sometimes|nullable|integer',
        ]);

        $course->update($data);

        return new CourseResource($course);
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        return response()->json(['message' => 'Course deleted successfully.'], 200);
    }
}
