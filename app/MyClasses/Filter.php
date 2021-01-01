<?php

namespace App\MyClasses;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Filter
{
 
      public function index(Request $request)
      {
        return Validator::make($request->all(), [
              
          'student_info.first_name' => 'required|max:255',
          'student_info.last_name' => 'required|max:255',
          'email' => 'required|email|unique:Students',
          'picture'=>'null',
          'student_info.phone_number' => 'required|string|max:50',
          'student_info.section_name' => 'required'
          
      ]);
      }
  
}


