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


        $t1 = new User;
        $t1->uID = "T1";
        $t1->firstname = "Klaas";
        $t1->lastname = "Klar";
        $t1->email = "Tkk@web.de";
        $t1->password = bcrypt('passme1234');
        $t1->description = "Hallo liebe KWM-Studierende. Mein Name ist Klaas und ich gebe in versch. KWM Kursen Nachhilfe. Lasst uns zusammen Spaß haben.";
        $t1->is_teacher = true;
        $t1->semester = 6;
        $t1->save();
        $timeslots = Timeslot::all()->pluck('id');
        $t1->timeslots()->sync($timeslots);
        $t1->save();


        $t2 = new User;
        $t2->uID = "T2";
        $t2->firstname = "Elsa";
        $t2->lastname = "Eber";
        $t2->email = "Tee@web.de";
        $t2->password = bcrypt('passme1234');
        $t2->description = "Hallo liebe KWM-Studierende. Mein Name ist Klaas und ich gebe in versch. KWM Kursen Nachhilfe. Lasst uns zusammen Spaß haben.";
        $t2->is_teacher = true;
        $t2->semester = 4;
        $t2->save();


        $s1 = new User;
        $s1->uID = "S1";
        $s1->firstname = "Michi";
        $s1->lastname = "Müller";
        $s1->email = "Smm@web.de";
        $s1->password = bcrypt('passme1234');
        $s1->description = "Hallo, ich bin eine KWM Studierende und brauche Nachhilfe in OE und PE.";
        $s1->is_teacher = false;
        $s1->semester = 4;
        $s1->save();

        $s2 = new User;
        $s2->uID = "S2";
        $s2->firstname = "Kati";
        $s2->lastname = "Kauer";
        $s2->email = "Skk@web.de";
        $s2->password = bcrypt('passme1234');
        $s2->description = "Hallo, ich bin eine KWM Studierende und brauche Nachhilfe in OE und PE.";
        $s2->is_teacher = false;
        $s2->semester = 2;
        $s2->save();
    }
}


