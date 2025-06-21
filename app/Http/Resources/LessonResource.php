<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
            'content' => $this->content,
            'order' => $this->order,

            'course' => $this->whenLoaded('course', function () {
                return [
                    'title' => $this->course->title,
                ];
            }),
            
        ];
    }
}
