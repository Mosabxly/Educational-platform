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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
             $table->string('certificate_url');
            $table->foreignId(column: 'student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId(column: 'course_id')->constrained('courses')->onDelete('cascade');
       
            $table->timestamps();
        });
    }

   
    
    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['course_id']);
        });

        Schema::dropIfExists('certificates');
    }
};
