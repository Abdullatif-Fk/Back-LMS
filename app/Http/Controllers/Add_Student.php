<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MyClasses\Filter;
use App\Models\Students;
use App\Models\Sections;



class Add_Student extends Controller
{
    public function store(Request $request)
    {error_log(111111);
        $filter=new Filter();
        error_log(print_r($request->input('student_info'),TRUE));
        
         $validator = $filter->index($request);

         if ($validator->fails()) {
             return response()->json([
                'status'=> 400,
                'message'=>$validator->messages()->first()
             ], 400); 
        }
        $section=Sections::where('name',$request->student_info['section_name']);
        $section_id=$section->first()->id;

        $student = new Students();
        $student->first_name = $request->input('student_info')['first_name'];
        $student->last_name = $request->input('student_info')['last_name'];
        $student->email = $request->input('email');
        $student->phone_number = $request->input('student_info')['phone_number'];
        $student->section_id = $section_id;
        $student->picture = "";

        $student->save();
        return response()->json([
            'status'=> 200,
            'message'=>"New Student added"
         ], 200); 
    }
}


