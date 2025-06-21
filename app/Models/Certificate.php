<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

     protected $fillable = [
        'certificate_url',
        'student_id',
        'course_id',
    ];


      public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }
    
    public function course() {
        return $this->belongsTo(Course::class);
    }



}
