<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class QuizResult extends Model
{
     use HasFactory;

    protected $fillable = [
        'score',
        'quiz_id',
        'student_id',
    ];

     public function quiz() {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
    
    public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }



}
