<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Panel;

use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
  
    use HasFactory, Notifiable , HasApiTokens ;

   
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'major',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    
   public function CourseResourc() {
    return $this->hasMany(Course::class, 'instructor_id');
}

    
    public function enrollmentResource() {
        return $this->hasMany(Enrollment::class, 'student_id');
    }
    
    public function ReviewsRelation() {
        return $this->hasMany(Review::class, 'student_id');
    }
    
    public function QuizResultResource() {
        return $this->hasMany(QuizResult::class, 'student_id');
    }
    
    public function CertificateResource() {
        return $this->hasMany(Certificate::class, 'student_id');
    }
    
    public function PaymentResource() {
        return $this->hasMany(Payment::class, 'student_id');
    }
    
}
