<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizzResource extends JsonResource
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
            'title' => $this->title,

            'results' => $this->results->map(fn($i) => [
                'score' => $i->score,
            ]),
            
        ];
    }
}
