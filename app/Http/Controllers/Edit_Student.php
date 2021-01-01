<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\Sections;
use App\Models\Classes;
use App\MyClasses\Filter;

use Illuminate\Support\Facades\Validator;


class Edit_Student extends Controller
{
   
    public function update(Request $request, $id)
    {
        $filter=new Filter();
        error_log($request->input('student_info')['email']);
        
         //error_log($request->input('student_info')['section_name']);
         $mail=Students::where('id',$id)->first()->email;

         if($mail!=$request->email)
         $validator = $filter->index($request);
        else
        $validator = Validator::make($request->all(), [
            
            'student_info.first_name' => 'required|max:255',
            'student_info.last_name' => 'required|max:255',
            'email' => 'required|email',
            'student_info.phone_number' => 'required|string|max:50',
            'student_info.section_name' => 'required'
            
        ]);

        
         
        if ($validator->fails()) {
            //  Session::flash('error', $validator->messages()->first());
            //  return redirect()->back()->withInput();
             return response()->json([
                'status'=> 400,
                'message'=>$validator->messages()->first()
             ], 400); 
        }
       
        else{
        $section=Sections::where('name',$request->student_info['section_name']);
        $section_id=$section->first()->id;

        Students::where('id', $id)
                ->update(['first_name' => $request->student_info['first_name'],
                'last_name' => $request->student_info['last_name'],
                'email'=>$request->email,
                'phone_number'=>$request->student_info['phone_number'],
                'section_id'=>$section_id,
                        ]
                        );


        return response()->json([
            'status'=> 200,
            'message'=>$request->all()
         ], 200); 
         
    }}

}
