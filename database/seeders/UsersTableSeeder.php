<?php

namespace Database\Seeders;

use App\Models\Timeslot;
use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stud1 = new User;
        $stud1->uID = "T1234";
        $stud1->firstname = "Lena";
        $stud1->lastname = "Lehrandra";
        $stud1->email = "LL@web.de";
        $stud1->password = bcrypt('secret');
        $stud1->description = "Hallo liebe KWM-Studierende. Mein Name ist Theresa und ich gebe in versch. KWM Kursen Nachhilfe. Lasst uns zusammen Spaß haben.";
        $stud1->is_teacher = false;
        $stud1->semester = 6;
        $stud1->save();

        $timeslots = Timeslot::all()->pluck('id');
        $stud1->timeslots()->sync($timeslots);
        $stud1->save();



        $stud2 = new User;
        $stud2->uID = "S1910456034";
        $stud2->firstname = "Christina";
        $stud2->lastname = "Wanke";
        $stud2->email = "CW@web.de";
        $stud2->password = bcrypt('secret');
        $stud2->description = "Hallo, ich bin eine KWM Studierende und brauche Nachhilfe in OE und PE.";
        $stud2->is_teacher = false;
        $stud2->semester = 6;
        $stud2->save();

        //$stud2->timeslots()->sync($timeslots);
        //$stud2->save();


/*
        $teach1 = new User;
        $teach1->uID = "S1710456012";
        $teach1->firstname = "Heiner";
        $teach1->lastname = "Weiner";
        $teach1->email = "HW@web.de";
        $teach1->password = bcrypt('secret');
        $teach1->description = "HW ist in da house";
        $teach1->is_teacher = true;
        $teach1->semester = 6;
        $teach1->save();

        //$teach1->timeslots()->sync($timeslots);
        //$teach1->save();

        $teach2 = new User;
        $teach2->uID = "T2050";
        $teach2->firstname = "Theresa";
        $teach2->lastname = "Teacher";
        $teach2->email = "TT@fhooe.at";
        $teach2->password = bcrypt('passme1234');
        $teach2->description = "Hallo! Ich gebe Nachhilfe in allen KWM Kursen";
        $teach2->is_teacher = true;
        $teach2->semester = 6;
        $teach2->save();

        //$timeslots = Timeslot::all()->pluck('id');
        //$teach2->timeslots()->sync($timeslots);
       // $teach2->save();

        */

    }

}


