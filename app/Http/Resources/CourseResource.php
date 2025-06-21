<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'level' => $this->level,
            'instructor_id' => $this->instructor_id,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'address' => $this->address,
            'course_status' => $this->course_status,
            'price' => $this->price,

            // Using this way when the relationship type is belongsTo 
            /*'category' => $this->whenLoaded('category', function () {
                return [
                    'name' => $this->category->name,
                ];
            }),*/

            'lessons' => $this->lessons->map(fn($i) => [
                'content' => $i->content,
                'order' => $i->order,
            ]),


        ];
    }
}
