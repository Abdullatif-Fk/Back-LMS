<?php

namespace App\Http\Controllers;
use App\Models\Classes;

use Illuminate\Http\Request;

class Fetch_Classes extends Controller
{
    public function index()
    {
        $sections= Classes::all();
        
        $myfinalarray=[];
        $myarray=[];
        foreach($sections as $section)
        {
            $myarray['class_name']=$section->name;
            array_push($myfinalarray,$myarray);
        }
        // error_log(print_r($sections));

         return response()->json([
            'status'=> 200,
            'message'=>$myfinalarray
         ], 200);  
    }
}