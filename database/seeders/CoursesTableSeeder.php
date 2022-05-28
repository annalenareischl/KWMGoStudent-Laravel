<?php

namespace Database\Seeders;

use App\Models\Timeslot;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use DateTime;

class CoursesTableSeeder extends Seeder
{
  public function run(){
   $course = new Course;
   //$u = new \App\Models\User;
           $course->cID = 'OOP1';
           $course->title = "OOP";
           $course->semester = 2;
           $course->description = "Hier machen wir funny JAVA Sachen";
           $u = User::all()->first();
           $course->user()->associate($u);
           $course->save();

      $users = User::all()->first();
      $course->user()->associate($users);

      $course->save();

      $timeslot = Timeslot::all()->pluck('id');
      $course->timeslot()->saveMany($timeslot);

      $course->save();

  }
}
