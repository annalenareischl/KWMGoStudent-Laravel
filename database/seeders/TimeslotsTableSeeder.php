<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Timeslot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Schema;

class TimeslotsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timeslot = new Timeslot;

        //$date=('12/03/2022');
        $timeslot-> day = Carbon::createFromFormat("Y.m.d", "2021.04.10", "Europe/Vienna");
        $timeslot-> from = Carbon::createFromTime(13, 00, 00, "Europe/Vienna");
        $timeslot-> to = Carbon::createFromTime(17, 00, 00, "Europe/Vienna");
        $timeslot->is_available = true;
        $c = Course::all()->first();
        $timeslot->course()->associate($c);
        $timeslot->save();


        /*$user=User::all()->pluck('id');

        $timeslot->users()->sync($user);
        $timeslot->save();
        */

    }
}
