<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\Sections;
use App\Models\Classes;

class Fetch_Student_By_Id extends Controller
{
    public function edit($id)
    {

        $student = Students::where("id",$id)->first();
//        error_log(var_dump($student));
        $student_info=[];
        $first_name=$student->first_name;
        $last_name=$student->last_name;
        $student_info["id"]=$student->id;
        $student_info["first_name"]=$first_name;
        $student_info["last_name"]=$last_name;
        $student_info['email']=$student->email;
        $student_info['phone_number']=$student->phone_number;
        $student_info['picture']=$student->picture;
        $section_id= $student->section_id;

        $class=Sections::where('id',$section_id);
        if ($class->count()>0)
            $class_id=$class->first()->class_id;
        else
            return response()->json([
                'status'=> 400,
                'message'=>"Couldn't find student"
            ], 200);  
        $student_info["section_id"]=$section_id;
        $student_info["section_name"]=$class->first()->name;
        $class_name=Classes::where('id',$class_id)->first()->name;
        $student_info["class_name"]=$class_name;

        $student_info["class_id"]=$class_id;
        

        return response()->json([
           'status'=> 200,
           'message'=>$student_info
        ], 200); 
        
      
    }
}
