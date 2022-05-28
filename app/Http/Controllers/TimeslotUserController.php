<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Timeslot;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimeslotUserController extends Controller
{

    public function booking (string $cID, string $tID, Request $request): JsonResponse{
        DB::beginTransaction();
        try {
            $course = Course::create($request->all());

            if(isset($request['timeslot']) && is_array($request['timeslot'])){
                foreach ($request['timeslot'] as $s){
                    $timeslot = Timeslot::firstOrNew([
                        'day' => $s['day'],
                        'from' => $s['from'],
                        'to' => $s['to'],
                        'is_available' => $s['is_available']
                    ]);
                    $course->timeslot()->save($timeslot);
                }
            }
            if(isset($request['user']) && is_array($request['user'])){
                foreach ($request['user'] as $u){
                    $user = User::firstOrNew([
                        'firstname' => $u['firstname'],
                        'lastname' => $u['lastname']
                    ]);
                    $course->user()->save($user);
                }
            }
            DB::commit();
            return response()->json($course, 201);
        }
        catch (\Exception $e){
            DB::rollBack();
            return response()->json("Saving Course failed!" . $e->getMessage(), 420);
        }
    }

}
