<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Sections;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class Fetch_Students extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students_info = [];
        $students = Students::with('Sections')->get();

        //return Sections::with('classes')->get()[0]->classes->id;
        //return Classes::with('sections')->get()[0];
        //return $students[0]->sections;

        foreach ($students as $student) {

            $student_info = [];
            $student_name = $student->first_name . " " . $student->last_name;
            $student_info["id"] = $student->id;
            $student_info["student_name"] = $student_name;
            $student_info['picture'] = $student->picture;

            $section_id = $student->section_id;
            $section = $student->sections::with('Classes')->get();
            //before , kel l esmon section ken esmon class
            // $class = Sections::where('id', $section_id);
            if ($section->count() > 0) {
                $class_id = $section->first()->class_id;
                $section_name = $section->first()->name;

                $student_info["section_name"] = $section_name;
                $classes = $section->first()->classes;
                //before
                // $classes = Classes::where('id', $class_id);
                $class_name = $classes->name;
                $student_info["class_name"] = $class_name;
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => "Couldn't find student",
                ], 200);
            }

            $student_info["section_id"] = $section_id;
            $student_info["class_id"] = $class_id;
            array_push($students_info, $student_info);
        }

        return response()->json([
            'status' => 200,
            'message' => $this->paginate($students_info),
        ], 200);

        //return Sections::with('classes')->get();
        //return Classes::with('sections')->get();
        // return Classes::with('students')->get();
        //return Students::with('classes')->get();
        //return Attendance::with('students')->get();
        //return Students::with('attendance')->get();
        //return Students_Attendances::all();

    }
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

}
