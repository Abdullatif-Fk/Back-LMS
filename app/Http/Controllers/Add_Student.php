<?php

namespace App\Http\Controllers;

use App\Models\Students;
use App\MyClasses\Filter;
use Illuminate\Http\Request;

class Add_Student extends Controller
{
    public function check($param, $request)
    {
        if ($request->all()[$param] == "undefined" || empty($request[$param])) {
            return response()->json([
                'status' => 400,
                'message' => "The $param field is required",
            ], 400);
        } else {
            return 0;
        }

    }
    public function store(Request $request)
    {
        $filter = new Filter();

        //error_log(print_r($request->all(),TRUE));
        //error_log(!$this->check("first_name", $request));
        if ($this->check("first_name", $request)) {
            return $this->check("first_name", $request);
        }

        if ($this->check("last_name", $request)) {
            return $this->check("last_name", $request);
        }

        if ($this->check("email", $request)) {
            return $this->check("email", $request);
        }

        if ($this->check("phone_number", $request)) {
            return $this->check("phone_number", $request);
        }

        if ($this->check("section_id", $request)) {
            return $this->check("section_id", $request);
        }

        $validator = $filter->index($request);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages()->first(),
            ], 400);
        }
        error_log($request->all()['section_id']);
        // $section = Sections::where('id', $request->all()['section_id']);
        $section_id = $request->all()['section_id'];

        $student = new Students();
        $student->first_name = $request->all()['first_name'];
        $student->last_name = $request->all()['last_name'];
        $student->email = $request->input('email');
        $student->phone_number = $request->all()['phone_number'];
        $student->section_id = $section_id;
        $picture = $request->file('picture');
        // error_log(print_r($request->file('picture')->getClientOriginalName(),TRUE));

        $new_picture = time() . $student->first_name . '-' . $student->last_name;
        $picture->move(public_path() . '/uploads/students/', $new_picture);
        $student->picture = 'uploads/students/' . $new_picture;

        $student->save();
        return response()->json([
            'status' => 200,
            'message' => "New Student added",
        ], 200);
    }
}
