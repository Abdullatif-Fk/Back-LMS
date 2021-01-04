<?php

namespace App\MyClasses;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Class_Filter
{

    public function index(Request $request)
    {

        return Validator::make($request->all(), [

            'name' => 'required|max:255|unique:Classes|min:1',

        ]);
    }

}
