<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Sections;
use App\Models\Students;

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
            //return $students;
            $student_info = [];
            $student_name = $student->first_name . " " . $student->last_name;
            $student_info["id"] = $student->id;
            $student_info["student_name"] = $student_name;
            $student_info['picture'] = $student->picture;

            $section_id = $student->section_id;
            $section = $student->sections::with('Classes')->where('id', $section_id)->get();
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
            'message' => $students_info,
        ], 200);

        //return Sections::with('classes')->get();
        //return Classes::with('sections')->get();
        // return Classes::with('students')->get();
        //return Students::with('classes')->get();
        //return Attendance::with('students')->get();
        //return Students::with('attendance')->get();
        //return Students_Attendances::all();

    }

}
