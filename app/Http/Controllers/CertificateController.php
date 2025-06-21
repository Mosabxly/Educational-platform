<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Http\Resources\CertificateResource;
class CertificateController extends Controller
{
    public function index()
    {
        //$certificates = Certificate::with(['student', 'course'])->get();
        $certificates = Certificate::with(['student', 'course'])->paginate(3);
        return CertificateResource::collection($certificates);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'certificate_url' => 'required|string|url',
        ]);

        $certificate = Certificate::create($data);

        return new CertificateResource($certificate);
    }

    public function show($id)
    {
        $certificate = Certificate::with(['student', 'course'])->findOrFail($id);
        return new CertificateResource($certificate);
    }

    public function update(Request $request, $id)
    {
        $certificate = Certificate::findOrFail($id);

        $data = $request->validate([
            'student_id' => 'sometimes|required|exists:users,id',
            'course_id' => 'sometimes|required|exists:courses,id',
            'certificate_url' => 'sometimes|required|string|url',
        ]);

        $certificate->update($data);

        return new CertificateResource($certificate);
    }

    public function destroy($id)
    {
        $certificate = Certificate::findOrFail($id);
        $certificate->delete();

        return response()->json(['message' => 'Certificate deleted successfully.'], 200);
    }
}
