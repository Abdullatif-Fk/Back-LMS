<?php

namespace App\Http\Controllers;

use App\Models\Students;
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

    //Store + update
    public function store(Request $request)
    {
        //request fiya : student_id l student + attandence_id (aw l status) +date mn l user

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
            'student_id' => 'required|max:255',
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
    public function show($id, Request $request)
    {

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
    function print(Request $request) {
        //fetch attendances

        //1- if for all days , required: student_id
        //2- if for a day , required: student_id + date

        //3- if for all days in specefic class , required:class_id
        //4- if for all days in specefic class and section , required:class_id,section_id
        //5- if for a day in specefi class and section :  class_id,section_id,date
        //6- if for a day in specefic class :  class_id,date
        error_log(11);
        $validator = Validator::make($request->all(), [
            'student_id' => 'required|max:255',
            'class_id' => 'required|max:255',
            'section_id' => 'required|max:255',
            'date_from' => 'required|max:255',

        ]);

        if ($validator->fails()) {
            $date_error = $class_id_error = $section_id_error = $student_id_error = 0;
            if ($validator->errors()->get('class_id')) {
                $class_id_error = $validator->errors()->get('class_id')[0] == 'The class id field is required.';
            }

            if ($validator->errors()->get('section_id')) {
                $section_id_error = $validator->errors()->get('section_id')[0] == 'The section id field is required.';
            }

            if ($validator->errors()->get('date_from')) {
                $date_error = $validator->errors()->get('date_from')[0] == 'The date from field is required.';
            }

            if ($validator->errors()->get('student_id')) {
                $student_id_error = $validator->errors()->get('student_id')[0] == 'The student id field is required.';
            }

            //1 and 2
            if ($class_id_error) {
                if ($student_id_error) {
                    return response()->json([
                        'status' => 400,
                        'message' => "Error ! ",
                    ], 400);
                }

                $student = Students_Attendances::where("student_id", $request->all()['student_id']);

                //1
                if ($date_error) {
                    $add_dates = [$student->get()];

                    return response()->json([
                        'status' => 400,
                        'message' => $add_dates,
                    ]);
                }
                //2
                else {

                    $student_date = $student->where('date', ">=", $request->all()['date_from'])->where('date', "<=", $request->all()['date_to'])->get();
                    return response()->json([
                        'status' => 400,
                        'message' => [$student_date],
                    ]);

                }
            }
            //3 4 5 and 6
            else {

                $All_Class = Students::with(['sections' => function ($query) use ($request) {
                    $query->with('classes')->where('class_id', $request->all()['class_id']);
                }])->get();
                $filter_classes = [];
                foreach ($All_Class as $class) {if ($class->sections) {
                    array_push($filter_classes, $class);
                }
                }
                //$Student_Section = $Student_Section->with('classes');

                $filter_students = [];

                //3 and 6
                if ($section_id_error) {
                    foreach ($filter_classes as $filter_class) {
                        array_push($filter_students, ["id" => $filter_class->id, "name" => $filter_class->first_name . " " . $filter_class->last_name, "class_name" => $filter_class->sections->classes->name, "class_id" => $filter_class->sections->classes->id]);
                    }

                    //3
                    if ($date_error) {
                        $filter_students_attendance = [];
                        foreach ($filter_students as $filter_student) {
                            //$att_array_for_one_student = [];
                            $student = Students_Attendances::where('student_id', $filter_student['id'])->get();

                            if (!count($student)) {
                                continue;
                            }

                            foreach ($student as $std) {
                                $filter_student['attendance_id'] = $std->attendance_id;
                                $filter_student['date'] = $std->date;
                                array_push($filter_students_attendance, [$filter_student]);

                            }

                            //array_push($filter_students_attendance, $att_array_for_one_student);
                        }
                        return response()->json([
                            'status' => 200,
                            'message' => $filter_students_attendance,
                        ]);
                    }
                    //6
                    else {
                        $filter_students_attendance = [];
                        foreach ($filter_students as $filter_student) {
                            //$att_array_for_one_student = [];
                            $student = Students_Attendances::where('student_id', $filter_student['id'])->where('date', ">=", $request->all()['date_from'])->where('date', "<=", $request->all()['date_to'])->get();

                            if (!count($student)) {
                                continue;
                            }
                            foreach ($student as $std) {
                                $filter_student['attendance_id'] = $std->attendance_id;
                                $filter_student['date'] = $std->date;
                                array_push($filter_students_attendance, [$filter_student]);

                            }

                            //array_push($filter_students_attendance, $att_array_for_one_student);
                        }
                        return response()->json([
                            'status' => 200,
                            'message' => $filter_students_attendance,
                        ]);

                    }
                }
                //4 and 5
                else {
                    foreach ($filter_classes as $filter_class) {
                        if ($filter_class->section_id == $request->all()['section_id']) {
                            array_push($filter_students, ["id" => $filter_class->id, "name" => $filter_class->first_name . " " . $filter_class->last_name, "class_name" => $filter_class->sections->classes->name, "class_id" => $filter_class->sections->classes->id,
                                "section_name" => $filter_class->sections->name, "section_id" => $filter_class->sections->id]);
                        }

                    }

                    //4
                    if ($date_error) {
                        $filter_students_attendance = [];
                        foreach ($filter_students as $filter_student) {
                            //$att_array_for_one_student = [];
                            $student = Students_Attendances::where('student_id', $filter_student['id'])->get();
                            if (!count($student)) {
                                continue;
                            }
                            foreach ($student as $std) {
                                $filter_student['attendance_id'] = $std->attendance_id;
                                $filter_student['date'] = $std->date;
                                array_push($filter_students_attendance, [$filter_student]);

                            }

                            //array_push($filter_students_attendance, $att_array_for_one_student);
                        }
                        return response()->json([
                            'status' => 200,
                            'message' => $filter_students_attendance,
                        ]);
                    }
                    //5
                    else {
                        $filter_students_attendance = [];
                        foreach ($filter_students as $filter_student) {
                            //$att_array_for_one_student = [];
                            $student = Students_Attendances::where('student_id', $filter_student['id'])->where('date', ">=", $request->all()['date_from'])->where('date', "<=", $request->all()['date_to'])->get();

                            if (!count($student)) {
                                continue;
                            }

                            foreach ($student as $std) {
                                $filter_student['attendance_id'] = $std->attendance_id;
                                $filter_student['date'] = $std->date;
                                array_push($filter_students_attendance, [$filter_student]);

                            }

                            // array_push($filter_students_attendance, $att_array_for_one_student);
                        }
                        return response()->json([
                            'status' => 200,
                            'message' => $filter_students_attendance,
                        ]);

                    }

                }
            }

        }
        return response()->json([
            'status' => 200,
            'message' => [],
        ]);
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
