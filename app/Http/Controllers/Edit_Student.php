<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\Sections;
use App\Models\Classes;

class Edit_Student extends Controller
{
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'first_name' => 'required|max:255',
        // ]);
        // error_log(print_r($request->input('student_info'),TRUE));
         error_log($request->input('student_info')['first_name']);


        $section=Sections::where('name',$request->student_info['section_name']);
        $section_id=$section->first()->id;

        Students::where('id', $id)
                ->update(['first_name' => $request->student_info['first_name'],
                'last_name' => $request->student_info['last_name'],
                'email'=>$request->student_info['email'],
                'phone_number'=>$request->student_info['phone_number'],
                'section_id'=>$section_id,
                        ]
                        );


        return response()->json([
            'status'=> 200,
            'message'=>$request->all()
         ], 200); 
         
    }

}
