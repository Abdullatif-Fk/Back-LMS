<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Sections;
use App\Models\Students;

class Fetch_Student_By_Id extends Controller
{
    public function edit($id)
    {

        $student = Students::with('Sections')->get();
        $student = $student->where("id", $id)->first();

        $student_info = [];
        $first_name = $student->first_name;
        $last_name = $student->last_name;
        $student_info["id"] = $student->id;
        $student_info["first_name"] = $first_name;
        $student_info["last_name"] = $last_name;
        $student_info['email'] = $student->email;
        $student_info['phone_number'] = $student->phone_number;
        $student_info['picture'] = $student->picture;
        $section_id = $student->section_id;

        $section = $student->sections::with('Classes')->where('id', $section_id)->get()->first();
        if ($section->count() > 0) {
            $class_id = $section->classes->id;
            $class_name = $section->classes->name;
        } else {
            return response()->json([
                'status' => 400,
                'message' => "Couldn't find student",
            ], 200);
        }

        $student_info["section_id"] = $section_id;
        $student_info["section_name"] = $section->name;
        $student_info["class_name"] = $class_name;

        $student_info["class_id"] = $class_id;

        return response()->json([
            'status' => 200,
            'message' => $student_info,
        ], 200);

    }
}
