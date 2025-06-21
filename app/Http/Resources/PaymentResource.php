<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //return parent::toArray($request);

         return [
            'id' => $this->id,
            'student_id' => $this->student_id,
            'course_id' => $this->course_id,
            'enrollment_id' => $this->enrollment_id,
            'payment_status' => $this->payment_status,

            'course' => $this->whenLoaded('course', function () {
                return [
                    'course_status' => $this->course->course_status,
                ];
            }),

        ];
    }
}
