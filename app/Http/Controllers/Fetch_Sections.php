<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Sections;

class Fetch_Sections extends Controller
{
    public function index()
    {
        $sections = Sections::with('Classes')->get();
        $sections_id = Sections::get('id');
        $sections_name = Sections::get('name');
        $myfinalarray = [];
        $myarray = [];
        foreach ($sections as $section) {
            $myarray['section_id'] = $section->id;
            $myarray['section_name'] = $section->name;
            $myarray['class_id'] = $section->class_id;
            //now

            $myarray['class_name'] = $section->classes->name;

            //before
            //$myarray['class_name'] = Classes::where('id', $section->class_id)->first()->name;
            array_push($myfinalarray, $myarray);
        }
        // error_log(print_r($sections));

        return response()->json([
            'status' => 200,
            'message' => $myfinalarray,
        ], 200);
    }
}
