<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Sections;
use App\Models\Students;
use App\MyClasses\Section_Filter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Sections::with('Classes')->get();

        $myfinalarray = [];
        $myarray = [];
        foreach ($classes as $class) {
            $myarray['ID'] = $class->id;
            $myarray['name'] = $class->name;
            $myarray['max_students'] = $class->max_students;
            $myarray['class_id'] = $class->class_id;
            $myarray['class_name'] = $class->classes->name;
            array_push($myfinalarray, $myarray);
        }
        // error_log(print_r($sections));

        return response()->json([
            'status' => 200,
            'message' => $myfinalarray,
        ], 200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $filter = new Section_Filter();
        if ($request->all()['name'] === "undefined" || empty($request['name'])) {
            return response()->json([
                'status' => 400,
                'message' => "The name field is required",
            ], 400);
        }
        if ($request->all()['max_students'] === "undefined" || empty($request['max_students'])) {
            return response()->json([
                'status' => 400,
                'message' => "The max number of students field is required",
            ], 400);
        }
        error_log(print_r($request->all(), true));

        if ($request->all()['class_id'] === "undefined" || empty($request['class_id'])) {
            return response()->json([
                'status' => 400,
                'message' => "The class name field is required",
            ], 400);
        }

        $validator = $filter->index($request);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages()->first(),
            ], 400);
        }

        $section = new Sections();
        $section->name = $request->all()['name'];

        $section->max_students = $request->all()['max_students'];
        error_log($request->all()['class_id']);
        $section->class_id = $request->all()['class_id'];

        $section->save();
        return response()->json([
            'status' => 200,
            'message' => "New Section added",
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {$section = Sections::with('Classes')->get()->where('id', $id)->first();
        $Section_info['name'] = $section->name;
        $Section_info['max_students'] = $section->max_students;
        $Section_info['class_id'] = $section->class_id;
        $Section_info['class_name'] = $section->classes->name;

        return response()->json([
            'status' => 200,
            'message' => $Section_info,
        ], 200); //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $filter = new Section_Filter();
        error_log(11);
        error_log(print_r($request->all(), true));

        if ($request->all()['name'] === "undefined" || empty($request->all()['name'])) {
            return response()->json([
                'status' => 400,
                'message' => "The name field is required",
            ], 400);
        }
        if ($request->all()['max_students'] === "undefined" || empty($request->all()['max_students'])) {
            return response()->json([
                'status' => 400,
                'message' => "The max number of students field is required",
            ], 400);
        }

        if ($request->all()['class_id'] === "undefined" || empty($request->all()['class_id'])) {
            return response()->json([
                'status' => 400,
                'message' => "The class name field is required",
            ], 400);
        }

        $section = Sections::where('id', $id)->first();

        $name = $section->name;

        if ($name != $request->all()['name']) {
            $validator = $filter->index($request);
        } else {
            $validator = Validator::make($request->all(), [

                'name' => 'required|max:255|min:1',
                'max_students' => 'required|max:255|min:1|integer',
                'class_id' => 'required|max:255|min:1',

            ]);
        }
        if ($validator->fails()) {

            return response()->json([
                'status' => 400,
                'message' => $validator->messages()->first(),
            ], 400);
        } else {

            Sections::where('id', $id)
                ->update(['name' => $request->all()['name'],
                    'max_students' => $request->all()['max_students'],
                    'class_id' => $request->all()['class_id'],
                ]
                );

            return response()->json([
                'status' => 200,
                'message' => "Edited successfully",
            ], 200);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section = Sections::where('id', $id);
        $students = Students::with('Sections')->get()->where('section_id', $id);
        if ($students->count() > 0) {
            return response()->json([
                'status' => 400,
                'message' => "You must delete the students collected to this section",
            ]);
        }
        if ($section->count() > 0) {

            $section->delete();
            return response()->json([
                'status' => 200,
                'message' => "Deleted successfully",
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'message' => "Error",
            ], 400);
        }
    }
}
