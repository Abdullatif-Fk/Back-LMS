<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MyClasses\Filter;
use App\Models\Students;
use App\Models\Sections;



class Add_Student extends Controller
{
    public function store(Request $request)
    {
        $filter=new Filter();
        
        //error_log(print_r($request->all(),TRUE));
       
         $validator = $filter->index($request);
         if ($validator->fails()) {
             return response()->json([
                'status'=> 400,
                'message'=>$validator->messages()->first()
             ], 400); 
        }
        $section=Sections::where('name',$request->all()['section_name']);
        $section_id=$section->first()->id;

        $student = new Students();
        $student->first_name = $request->all()['first_name'];
        $student->last_name = $request->all()['last_name'];
        $student->email = $request->input('email');
        $student->phone_number = $request->all()['phone_number'];
        $student->section_id = $section_id;
        $picture = $request->file('picture');
       // error_log(print_r($request->file('picture')->getClientOriginalName(),TRUE));

        $new_picture=time().$student->first_name.'-'.$student->last_name;
        $picture->move(public_path().'/uploads/students/',$new_picture);
        $student->picture='uploads/students/'.$new_picture;

        $student->save();
        return response()->json([
            'status'=> 200,
            'message'=>"New Student added"
         ], 200); 
    }
}


