<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TimeslotUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();

});

//Hier alle Routen für MEMBERS:
    /*
     * All: Kurse sehen;
     * Teacher: Kurse erstellen/updaten/löschen
     * Student: Kurs buchen */
Route::group(['middleware' => ['api', 'auth.jwt']], function (){

    // PRIORITY: use token to get user information
    Route::post('/profile', [AuthController::class, 'me']);

    // do business logic stuff (now you know the username, email, userId ...)
    Route::post('courses', [CourseController::class, 'save']);
    //Route::delete('/courses/{cID}', [CourseController::class,'delete']);
    Route::delete('courses/{cID}', [CourseController::class,'delete']);

    //Route::put('/courses/{id}', [CourseController::class, 'update']);

    // TODO: update timeslots similar to CourseController update
    Route::put('/timeslots/{id}', [TimeslotController::class, 'update']); // use this endpoint to set the is_available boolean (booking-process)

    // TODO: to book timeslots (in the request body you have to send the timeslotUser JSON object with timeslot id and user id)
    Route::post('/timeslotUser/', [TimeslotUser::class, 'save']);

    // TODO: return all booked timeslots of user (example below)
    Route::get('/courses/booked/{userId}', [TimeslotUser::class, 'findBookedCoursesByUser']);

    // TODO: return all free timeslots; something like that: Timeslot::join('Course', 'course.id', '=', 'timeslot.course_id')->where('is_available', true)
    Route::get('/courses/free/', [CourseController::class, 'findFreeCourses']);

    // more protected routes...

    // logout should only be possible if user is already authenticated
    Route::post('auth/logout', [AuthController::class,'logout']);


});

//Hier alle Routen für ALLE, NICHT EINGELOGGT:
/* All: Kurse sehen;
    -> nicht mehr Funktionen
*/
Route::post('auth/login', [AuthController::class, 'login']);
Route::get('courses', [CourseController::class, 'index']);


Route::put('courses/{cID}', [CourseController::class, 'update']);
Route::delete('courses/{cID}', [CourseController::class,'delete']);

Route::post('course', [CourseController::class,'save']);
Route::post('auth/logout', [AuthController::class,'logout']);


//Route::post('auth/login', [AuthController::class, 'login']);
Route::post('courses', [CourseController::class, 'save']);
Route::get('courses/{title}', [CourseController::class, 'findByTitle']);
Route::get('courses/identify/{cID}', [CourseController::class, 'findBycID']);
Route::get('courses/identify/{cID}/timeslots/identify', [CourseController::class, 'findByDateID']);
Route::get('courses/{semester}', [CourseController::class, 'findBySemester']);
Route::get('courses/search/{searchTerm}', [CourseController::class, 'findBySearchTerm']);

Route::post('course/identify/{cID}/timeslots/{id}', [Timeslot::class,'booking']);


