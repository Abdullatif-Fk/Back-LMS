<?php

namespace App\MyClasses;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class adminFilter
{

    public function index(Request $request)
    {

        return Validator::make($request->all(), [

            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:Admins',
            'password' => 'required|min:6',
            'repeat_password' => 'required|min:6',
            'picture' => 'required|image',
            'phone_number' => 'required|string|max:50',

        ]);
    }

}
