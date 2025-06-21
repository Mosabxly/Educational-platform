<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
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
            'enrolled_at' => $this->enrolled_at,
            'retreat' => $this->retreat,

            'payment' => $this->whenLoaded('payment', function () {
                return [
                    'payment_status' => $this->payment->payment_status,
                ];
            }),

        ];
    }
}
