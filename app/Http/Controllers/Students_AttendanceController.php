<?php

namespace App\Http\Controllers;

use App\Models\Students_Attendances;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Students_AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //request fiya : id l student + attandence_id (aw l status) +date l user

        if ($request->all()['attendance_id'] === "undefined") {
            return response()->json([
                'status' => 400,
                'message' => "Error1 ! ",
            ], 400);
        }
        if ($request->all()['date'] === "undefined" || empty($request->all()['date'])) {
            return response()->json([
                'status' => 400,
                'message' => "Error2 ! ",
            ], 400);
        }

        //Check if attendance_id exist ?
        $validator = Validator::make($request->all(), [

            'attendance_id' => 'required|max:255',
            'date' => 'required|max:255',

        ]);

        //if yes , return error message

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages()->first(),
            ], 400);
        }

        //now check if the combinaison of attendance_id + student id is unique or not
        //if yes, so it's add , if not so do edit
        $date = $request->all()['date'];

        $Add_OR_Edit_Check = Validator::make($request->all(), [

            'student_id' => Rule::unique('Students_Attendances')->where(function ($query) use ($date) {

                return $query->where('date', "$date");
            }),

        ]);

        //if it's not unique so edit

        if ($Add_OR_Edit_Check->fails()) {

            Students_Attendances::where('student_id', $request->all()['student_id'])
                ->update(['attendance_id' => $request->all()['attendance_id'],
                    'date' => $request->all()['date'],
                    'student_id' => $request->all()['student_id'],
                ]
                );

            return response()->json([
                'status' => 400,
                'message' => "Updated",
            ], 400);
        }

        //if it's unique , so add

        $students_attendances = new Students_Attendances();
        $students_attendances->attendance_id = $request->all()['attendance_id'];
        $students_attendances->date = $request->all()['date'];
        $students_attendances->student_id = $request->all()['student_id'];

        $students_attendances->save();
        return response()->json([
            'status' => 200,
            'message' => "Added",
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
