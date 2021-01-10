<?php

namespace App\MyClasses;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Section_Filter
{

    public function index(Request $request)
    {

        return Validator::make($request->all(), [

            'name' => 'required|max:255|min:1',
            'max_students' => 'required|max:255|min:1|integer',
            'class_id' => 'required|max:255|min:1',

        ]);
    }

}
