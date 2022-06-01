<?php
namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\Timeslot;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
class CourseController extends Controller
{

    private function parseRequest(Request $request) : Request {
        if (isset($request['date'])) {
            $date = new \DateTime($request->date);
            $request['date'] = $date;
        }
        if (isset($request['from'])) {
            $request['from'] = Carbon::createFromFormat('H:i:s', $request->from, "Europe/Vienna");
        }
        if (isset($request['to'])) {
            $request['to'] = Carbon::createFromFormat('H:i:s', $request->to, "Europe/Vienna");
        }
        return $request;
    }

    public function index() : JsonResponse{
        $courses = Course::with(['timeslot', 'user'])->get();
        return response()->json($courses, 200);
    }
    public function findByTitle(string $title) : Course {
        return Course::where('title', $title)
            ->with(['timeslot', 'user'])
            ->first();
    }

    public function findBycID(string $cID) : Course {
        return Course::where('cID', $cID)
            ->with(['timeslot', 'user'])
            ->first();
    }

    public function findBySemester(int $semester) : Course {
        return Course::where('semester', $semester)
            ->with(['timeslot', 'user'])
            ->first();
    }
    public function findBySearchTerm(string $searchTerm) {
        return Course::with(['timeslot', 'user'])
            ->where('title', 'LIKE', '%' . $searchTerm. '%')
            ->orWhere('description' , 'LIKE', '%' . $searchTerm. '%')
            /* search term in users name */
            ->orWhereHas('user', function($query) use ($searchTerm) {
                $query->where('firstname', 'LIKE', '%' . $searchTerm. '%')
                    ->orWhere('lastname', 'LIKE',  '%' . $searchTerm. '%');
            })->get();
    }


    public function save(Request $request) : JsonResponse{
        $request = $this->parseRequest($request);
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

    //check Teacher State



    /**
     * returns 200 if course deleted successfully, throws excpetion if not
     */
    public function delete(string $cID) : JsonResponse
    {
        $course = Course::where('cID', $cID)->first();
        if ($course != null) {
            $course->delete();
        }
        else
            throw new \Exception("course couldn't be deleted - it does not exist");
        return response()->json('course (' . $cID . ') successfully deleted', 200);

    }

    public function update(Request $request, string $cID) : JsonResponse
    {
        DB::beginTransaction();
        try {
            $course = Course::with(['timeslot', 'user'])
                ->where('cID', $cID)->first();
            if ($course != null) {
                $request = $this->parseRequest($request);
                $course->update($request->all());

                //delete all old slots
                $course->timeslot()->delete();
                // save slots
                if (isset($request['timeslot']) && is_array($request['timeslot'])) {
                    foreach ($request['timeslot'] as $s) {
                        $timeslot = Timeslot::firstOrNew([
                            'day' => $s['day'],
                            'from' => $s['from'],
                            'to' => $s['to'],
                            'is_available' => $s['is_available']
                        ]);
                        $course->timeslot()->save($timeslot);
                    }
                }
            }
            DB::commit();
            $c = Course::with(['timeslot', 'user'])
                ->where('cID', $cID)->first();
            // return a vaild http response
            return response()->json($c, 201);
        }
        catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("updating course failed: " . $e->getMessage(), 420);
        }
    }


}
