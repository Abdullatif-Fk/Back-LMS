<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Sections;
use App\MyClasses\Class_Filter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = Classes::all();

        $myfinalarray = [];
        $myarray = [];
        foreach ($classes as $class) {
            $myarray['ID'] = $class->id;
            $myarray['name'] = $class->name;
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

        $filter = new Class_Filter();
        if ($request->all()['name'] === "undefined" || empty($request['name'])) {
            return response()->json([
                'status' => 400,
                'message' => "The name field is required",
            ], 400);
        }
        $validator = $filter->index($request);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages()->first(),
            ], 400);
        }

        $Class = new Classes();
        error_log(112);
        $Class->name = $request->all()['name'];

        $Class->save();
        return response()->json([
            'status' => 200,
            'message' => "New Class added",
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $class = Classes::where("id", $id)->first();
        $Class_info['name'] = $class->name;

        return response()->json([
            'status' => 200,
            'message' => $Class_info,
        ], 200);

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

        $filter = new Class_Filter();

        if ($request->all()['name'] === "undefined" || empty($request['name'])) {
            return response()->json([
                'status' => 400,
                'message' => "The name field is required",
            ], 400);
        }
        $class = Classes::where('id', $id)->first();

        $name = $class->name;

        if ($name != $request->all()['name']) {
            $validator = $filter->index($request);
        } else {
            $validator = Validator::make($request->all(), [

                'name' => 'required|max:255|min:1',

            ]);
        }
        if ($validator->fails()) {

            return response()->json([
                'status' => 400,
                'message' => $validator->messages()->first(),
            ], 400);
        } else {

            Classes::where('id', $id)
                ->update(['name' => $request->all()['name'],

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
        $Class = Classes::where('id', $id);
        $sections = Sections::with('Classes')->get()->where('class_id', $id);
        if ($sections->count() > 0) {
            return response()->json([
                'status' => 400,
                'message' => "You must delete the sections collected to this class",
            ]);
        }
        if ($Class->count() > 0) {

            $Class->delete();
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
