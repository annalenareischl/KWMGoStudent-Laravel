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

//nur möglich wenn anmgeledet
Route::group(['middleware' => ['api', 'auth.jwt']], function (){

});
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('courses', [CourseController::class, 'save']);
//Route::put('courses/{cID}', [CourseController::class,'update']);
Route::delete('courses/{cID}', [CourseController::class,'delete']);
Route::post('auth/logout', [AuthController::class,'logout']);
//Route::delete('courses/{cID}', [CourseController::class, 'delete']);
Route::put('courses/{id}', [CourseController::class, 'update']);

//nur möglich für Suchende
// können ihre Slots ansehen




//nur mögllich für Lehrende
// können ihren Kurs bearbeiten
// können ihren Kurs löschen
// können ihre Kurse ansehen

//möglich für alle

//Route::post('auth/login', [AuthController::class, 'login']);
Route::get('courses', [CourseController::class, 'index']);
Route::get('courses/{title}', [CourseController::class, 'findByTitle']);
Route::get('courses/identify/{cID}', [CourseController::class, 'findBycID']);
Route::get('courses/identify/{cID}/timeslots/identify', [CourseController::class, 'findByDateID']);
Route::get('courses/{semester}', [CourseController::class, 'findBySemester']);
Route::get('courses/search/{searchTerm}', [CourseController::class, 'findBySearchTerm']);
Route::post('course', [CourseController::class,'save']);


Route::post('course/identify/{cID}/{timeslot_id}', [CourseController::class,'booking']);



/*
Route::get('courses', [CourseController::class, 'index']);
Route::delete('courses/{cID}', [CourseController::class, 'delete']);
Route::put('courses/{id}', [CourseController::class, 'update']);
Route::get('courses/{title}', [CourseController::class, 'findByTitle']);
Route::get('courses/identify/{cID}', [CourseController::class, 'findBycID']);
Route::get('courses/{semester}', [CourseController::class, 'findBySemester']);
Route::get('courses/search/{searchTerm}', [CourseController::class, 'findBySearchTerm']);
Route::post('courses', [CourseController::class, 'save']);
Route::post('auth/login', [AuthController::class, 'login']);

*/

