<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use App\MyClasses\Class_Filter;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes= Classes::all();
        
        $myfinalarray=[];
        $myarray=[];
        foreach($classes as $class)
        {
            $myarray['ID']=$class->id;
            $myarray['name']=$class->name;
            array_push($myfinalarray,$myarray);
        }
        // error_log(print_r($sections));

         return response()->json([
            'status'=> 200,
            'message'=>$myfinalarray
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
        

        $filter=new Class_Filter();
        
         $validator = $filter->index($request);
         
         if ($validator->fails()) {
             return response()->json([
                'status'=> 400,
                'message'=>$validator->messages()->first()
             ], 400); 
        }
   
        $Class = new Classes();
        error_log(112);
        $Class->name = $request->all()['name'];
        

        $Class->save();
        return response()->json([
            'status'=> 200,
            'message'=>"New Class added"
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
        $Class = Classes::where('id',$id);

        
        if ($Class->count() > 0) {
            
            $Class->delete();
            return response()->json([
                'status'=> 200,
                'message'=>"Deleted successfully"
             ], 200); 
         }
         else
         {
            return response()->json([
                'status'=> 400,
                'message'=>"Error"
             ], 400); 
         }
    }
}
