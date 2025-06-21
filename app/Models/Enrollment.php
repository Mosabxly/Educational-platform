<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
      use HasFactory;

    protected $fillable = [
        'enrolled_at',
        'student_id',
        'course_id',
        'retreat', 
    ];

    public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }
    
    public function course() {
        return $this->belongsTo(Course::class);
    }
    
    public function payment() {
        return $this->hasOne(Payment::class);
    }

    
public function instructor()
{
    return $this->belongsTo(User::class, 'instructor_id');
}
}
