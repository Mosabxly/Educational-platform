<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Http\Resources\EnrollmentResource;

class EnrollmentController extends Controller
{
      public function index()
    {
        //$enrollments = Enrollment::with(['student', 'course', 'payment'])->get();
        $enrollments = Enrollment::with(['student', 'course', 'payment'])->paginate(3);
        return EnrollmentResource::collection($enrollments);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'enrolled_at' => 'required|date',
            'retreat' => 'required|boolean',
        ]);

        $enrollment = Enrollment::create($data);

        return new EnrollmentResource($enrollment);
    }

    public function show($id)
    {
        $enrollment = Enrollment::with(['student', 'course', 'payment'])->findOrFail($id);
        return new EnrollmentResource($enrollment);
    }

    public function update(Request $request, $id)
    {
        $enrollment = Enrollment::findOrFail($id);

        $data = $request->validate([
            'student_id' => 'sometimes|required|exists:users,id',
            'course_id' => 'sometimes|required|exists:courses,id',
            'enrolled_at' => 'sometimes|required|date',
            'retreat' => 'sometimes|required|boolean',
        ]);

        $enrollment->update($data);

        return new EnrollmentResource($enrollment);
    }

    public function destroy($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();

        return response()->json(['message' => 'Enrollment deleted successfully.'], 200);
    }
}
