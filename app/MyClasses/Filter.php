<?php

namespace App\MyClasses;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Filter
{
 
      public function index(Request $request)
      {
        //error_log(print_r($request,TRUE));
        
        //error_log(print_r($request->all()['first_name'],TRUE));
        //error_log($request->all());

        
        return Validator::make($request->all(), [
              
          'first_name' => 'required|max:255',
          'last_name' => 'required|max:255',
          'email' => 'required|email|unique:Students',
          'picture'=>'required|image',
          'phone_number' => 'required|string|max:50',
          'section_name' => 'required'
          
      ]);
      }
  
}


