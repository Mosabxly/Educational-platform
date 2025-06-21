<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
     use HasFactory;

    protected $fillable = [
        'rating',
        'comment',
        'course_id',
        'student_id',
    ];

    public function course() {
        return $this->belongsTo(Course::class);
    }
    
    public function student() {
         return $this->belongsTo(User::class, 'student_id');
    }
}
