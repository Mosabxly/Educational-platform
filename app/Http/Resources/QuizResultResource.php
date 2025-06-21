<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
      //  return parent::toArray($request);
        return [
            'id' => $this->id,
            'quiz_id' => $this->quiz_id,
            'student_id' => $this->student_id,
            'score' => $this->score,

            'quiz' => $this->whenLoaded('quiz', function () {
                return [
                    'title' => $this->quiz->title,
                ];
            }),

        ];
    }
}
