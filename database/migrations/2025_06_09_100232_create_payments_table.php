<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
             $table->enum('payment_status', ['pending', 'paid', 'free'])->default('pending');
            $table->foreignId(column: 'student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId(column: 'course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId(column: 'enrollment_id')->constrained('enrollments')->onDelete('cascade');
      
            $table->timestamps();
        });
    }

    
      public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['course_id']);
            $table->dropForeign(['enrollment_id']);
        });

        Schema::dropIfExists('payments');
    }
};
