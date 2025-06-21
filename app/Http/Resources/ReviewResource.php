<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       // return parent::toArray($request);

          return [
            'id' => $this->id,
            'course_id' => $this->course_id,
            'student_id' => $this->student_id,
            'rating' => $this->rating,
            'comment' => $this->comment,

            'student' => $this->whenLoaded('student', function () {
                return [
                    'name' => $this->student->name,
                ];
            }),

        ];
    }
}
