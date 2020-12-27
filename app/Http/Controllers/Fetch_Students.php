<?php

namespace App\Http\Controllers;
use App\Models\Sections;
use App\Models\Classes;
use App\Models\Students;
use App\Models\Attendance;
use App\Models\Students_Attendances;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\Collection;

use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Http\Request;

class Fetch_Students extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $students_info=[];
        $students = Students::with('Sections')->get();
        foreach ($students as $student)
        {
    
        $student_info=[];
        $student_name=$student->first_name." ".$student->last_name;
        $student_info["student_name"]=$student_name;
        $section_id= $student->section_id;
        $class_id=Sections::where('id',$section_id)->first()->class_id;
        $student_info["section_id"]=$section_id;
        $student_info["class_id"]=$class_id;
        array_push($students_info,$student_info);
        }

        return $this->paginate($students_info);
      
         //return Sections::with('classes')->get();
        //return Classes::with('sections')->get();
        // return Classes::with('students')->get();
        //return Students::with('classes')->get();
        //return Attendance::with('students')->get();
        //return Students::with('attendance')->get();
        //return Students_Attendances::all();
        
    }
    public function paginate($items, $perPage = 5, $page = null, $options = [])

    {

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items = $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);

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
        //
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
