<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'title',
        'description',
        'level',
        'start_at',
        'end_at',
        'address',
        'course_status',
        'price',
        'category_id',
        'instructor_id',
        'invoice_path',
    ];


    
    public function instructor() {
        return $this->belongsTo(User::class, 'instructor_id');
    }
    
    public function category() {
        return $this->belongsTo(Category::class);
    }
    
    public function EnrollmentResource() {
        return $this->hasMany(Enrollment::class);
    }
    
    public function lessons() {
        return $this->hasMany(Lesson::class);
    }
    
    public function reviews() {
        return $this->hasMany(Review::class);
    }
    
    public function quizzes() {
        return $this->hasMany(Quiz::class);
    }
    public function certificate()
{
    return $this->hasOne(Certificate::class);
}

    public function payments() {
        return $this->hasMany(Payment::class);
    }
    
}
