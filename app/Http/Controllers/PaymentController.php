<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Http\Resources\PaymentResource;

class PaymentController extends Controller
{
     public function index()
    {
        //$payments = Payment::with(['student', 'course', 'enrollment'])->get();
        $payments = Payment::with(['student', 'course', 'enrollment'])->paginate(3);
        return PaymentResource::collection($payments);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'enrollment_id' => 'required|exists:enrollments,id',
            'payment_status' => 'required|in:pending,paid,free',
        ]);

        $payment = Payment::create($data);

        return new PaymentResource($payment);
    }

    public function show($id)
    {
        $payment = Payment::with(['student', 'course', 'enrollment'])->findOrFail($id);
        return new PaymentResource($payment);
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $data = $request->validate([
            'student_id' => 'sometimes|required|exists:users,id',
            'course_id' => 'sometimes|required|exists:courses,id',
            'enrollment_id' => 'sometimes|required|exists:enrollments,id',
            'payment_status' => 'sometimes|required|in:pending,paid,free',
        ]);

        $payment->update($data);

        return new PaymentResource($payment);
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return response()->json(['message' => 'Payment deleted successfully.'], 200);
    }
}
