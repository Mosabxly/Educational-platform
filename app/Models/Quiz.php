<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Quiz extends Model
{
      use HasFactory;

    protected $table = 'quizzes';

    protected $fillable = [
        'title',
        'course_id',
    ];


      public function course() {
        return $this->belongsTo(Course::class);
    }
    
    public function results() {
        return $this->hasMany(QuizResult::class, 'quiz_id');
    }
    
}
