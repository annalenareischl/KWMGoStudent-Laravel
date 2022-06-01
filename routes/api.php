<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TimeslotUserController;
use App\Models\Timeslot;
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

    Route::post('/profile', [AuthController::class, 'me']);
    Route::post('courses', [CourseController::class, 'save']);

    Route::delete('courses/{cID}', [CourseController::class,'delete']);

    Route::post('auth/logout', [AuthController::class,'logout']);


    //Route::post('courses', [CourseController::class, 'save']);
    Route::get('courses/{title}', [CourseController::class, 'findByTitle']);
    Route::get('courses/identify/{cID}', [CourseController::class, 'findBycID']);
    Route::get('courses/identify/{cID}/timeslots/identify', [CourseController::class, 'findByDateID']);
    Route::get('courses/{semester}', [CourseController::class, 'findBySemester']);
    Route::get('courses/search/{searchTerm}', [CourseController::class, 'findBySearchTerm']);

    Route::post('course/identify/{cID}/timeslots/{id}', [Timeslot::class,'booking']);

    Route::put('courses/{cID}', [CourseController::class, 'update']);
    Route::delete('courses/{cID}', [CourseController::class,'delete']);

    Route::post('course', [CourseController::class,'save']);
    Route::post('auth/logout', [AuthController::class,'logout']);



});

//Hier Routen für ALLE, NICHT EINGELOGGT:
/* All: Kurse sehen;
    -> nicht mehr Funktionen
*/
Route::post('auth/login', [AuthController::class, 'login']);
Route::get('courses', [CourseController::class, 'index']);




