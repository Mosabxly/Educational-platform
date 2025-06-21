<?php


use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\QuizzController;
use App\Http\Controllers\QuizResultController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\PaymentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


 /* ********************Authentication Routes******************** */
 
 Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
/* ******************** ******************** */
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::get('/logout', [AuthController::class, 'logout']);
});



                        /* ******************** ******************** */



Route::resource('categories', CategoryController::class)->only([
    'index', 'show', 'store', 'update', 'destroy',
]);


                     /* ******************** ******************** */
    //////////User Routes//////////
Route::resource('users', UserController::class)->only([
    'index', 'show', 'store', 'update', 'destroy',
]);

                     /* ******************** ******************** */
        //////////Course Routes//////////
Route::resource('courses', CourseController::class)->only([
    'index', 'show', 'store', 'update', 'destroy',
]);

                    /* ******************** ******************** */

      //////////Enrollment Routes//////////
Route::resource('enrollments', EnrollmentController::class)->only([
    'index', 'show', 'store', 'update', 'destroy',
]);
                  /* ******************** ******************** */

    //////////Lesson Routes//////////
Route::resource('lessons', LessonController::class)->only([
    'index', 'show', 'store', 'update', 'destroy',
]);

   /* ******************** ******************** */
     //////////Review Routes//////////
Route::resource('reviews', ReviewController::class)->only([
    'index', 'show', 'store', 'update', 'destroy',
]);
   /* ******************** ******************** */

  //////////Quiz Routes//////////
Route::resource('quizzes', QuizzController::class)->only([
    'index', 'show', 'store', 'update', 'destroy',
]);

   /* ******************** ******************** */
   //////////QuizResult Routes//////////
Route::resource('quizResults', QuizResultController::class)->only([
    'index', 'show', 'store', 'update', 'destroy',
]);

   /* ******************** ******************** */
   //////////Certificate Routes//////////
Route::resource('certificates', CertificateController::class)->only([
    'index', 'show', 'store', 'update', 'destroy',
]);


                       /* ******************** ******************** */
     //////////Payment Routes//////////
Route::resource('payments', PaymentController::class)->only([
    'index', 'show', 'store', 'update', 'destroy',
]);
