<?php

namespace App\Http\Controllers;

use App\Models\Students;
use App\MyClasses\Filter;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Edit_Student extends Controller
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
    public function update(Request $request, $id)
    {

        $filter = new Filter();
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
        $student = Students::where('id', $id)->first();
        $mail = $student->email;

        if ($mail != $request->all()['email']) {
            $validator = $filter->index($request);
        } else {
            $validator = Validator::make($request->all(), [

                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email',
                'picture' => 'required|image',
                'phone_number' => 'required|string|max:50',
                'section_id' => 'required',

            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages()->first(),
            ], 400);
        } else {
            // $section = Sections::where('name', $request->all()['section_id']);
            $section_id = $request->all()['section_id'];
            $picture = $request->file('picture');
            // error_log(print_r($request->file('picture')->getClientOriginalName(),TRUE));
            $new_picture = time() . $student->first_name . '-' . $student->last_name;
            // $new_picture=time().$picture->getClientOriginalName();
            if (File::exists($student->picture)) {
                File::delete($student->picture);
            }
            $picture->move(public_path() . '/uploads/students/', $new_picture);

            Students::where('id', $id)
                ->update(['first_name' => $request->all()['first_name'],
                    'last_name' => $request->all()['last_name'],
                    'email' => $request->all()['email'],
                    'phone_number' => $request->all()['phone_number'],
                    'section_id' => $section_id,
                    'picture' => 'uploads/students/' . $new_picture,
                ]
                );

            return response()->json([
                'status' => 200,
                'message' => "Edited successfully",
            ], 200);

        }}

}
