<?php

namespace App\Http\Controllers;

use App\Models\Classes;

class Fetch_Classes extends Controller
{
    public function index()
    {
        $classes = Classes::all();

        $myfinalarray = [];
        $myarray = [];
        foreach ($classes as $class) {
            $myarray['class_name'] = $class->name;
            $myarray['class_id'] = $class->id;
            array_push($myfinalarray, $myarray);
        }
        // error_log(print_r($sections));

        return response()->json([
            'status' => 200,
            'message' => $myfinalarray,
        ], 200);
    }
}
