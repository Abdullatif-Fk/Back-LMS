<?php

namespace App\Http\Controllers;

use App\Models\Admins;
use App\MyClasses\adminFilter;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins_info = [];
        $admins = Admins::all();
        foreach ($admins as $admin) {
            //return $students;
            $admin_info = [];
            $admin_name = $admin->first_name . " " . $admin->last_name;
            $admin_info["id"] = $admin->id;
            $admin_info["admin_name"] = $admin_name;
            $admin_info["phone_number"] = $admin->phone_number;
            $admin_info["email"] = $admin->email;
            $admin_info['picture'] = $admin->picture;
            array_push($admins_info, $admin_info);
        }
        return response()->json([
            'status' => 200,
            'message' => $admins_info,
        ], 200);

    }
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
        $filter = new adminFilter();

        //error_log(print_r($request->all(),TRUE));
        //error_log(!$this->check("first_name", $request));

        if ($this->check("first_name", $request)) {
            return $this->check("first_name", $request);
        }

        if ($this->check("last_name", $request)) {
            return $this->check("last_name", $request);
        }

        if ($this->check("email", $request)) {
            return $this->check("email", $request);
        }
        if ($this->check("password", $request)) {
            return $this->check("password", $request);
        }
        if ($this->check("repeat_password", $request)) {
            return $this->check("repeat_password", $request);
        }

        if ($this->check("phone_number", $request)) {
            return $this->check("phone_number", $request);
        }

        $validator = $filter->index($request);
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages()->first(),
            ], 400);
        }

        if ($request->all()['password'] != $request->all()['repeat_password']) {
            return response()->json([
                'status' => 400,
                'message' => "Password and verify password must be the same",
            ], 400);
        }

        $admin = new Admins();
        $admin->first_name = $request->all()['first_name'];
        $admin->last_name = $request->all()['last_name'];
        $admin->email = $request->input('email');

        error_log($request->input('password'));
        $admin->password = bcrypt($request->input('password'));
        $admin->phone_number = $request->all()['phone_number'];
        $picture = $request->file('picture');
        error_log(print_r($request->file('picture')->getClientOriginalName(), true));
        $new_picture = time() . $admin->first_name . '-' . $admin->last_name;
        $picture->move(public_path() . '/uploads/admins/', $new_picture);
        $admin->picture = 'uploads/admins/' . $new_picture;
        $admin->save();
        return response()->json([
            'status' => 200,
            'message' => "New Admin added",
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

        $admin = Admins::where('id', $id)->first();

        return response()->json([
            'status' => 200,
            'message' => $admin,
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
        //

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

        // if ($this->check("new_password", $request)) {
        //     return $this->check("password", $request);
        // }
        if ($this->check("old_password", $request)) {
            return $this->check("old_password", $request);
        }

        $admin = Admins::where('id', $id)->first();
        $mail = $admin->email;
        $pass = $admin->password;

        if (!Hash::check($request->all()['old_password'], $pass)) {
            return response()->json([
                'status' => 400,
                'message' => "Incorrect Password!",
            ], 400);
        }

        if ($mail != $request->all()['email']) {
            $validator = Validator::make($request->all(), [

                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|Unique:Admins|email',
                'picture' => 'required|image',
                'phone_number' => 'required|string|max:50',
                'old_password' => 'required',

            ]);
        } else {
            $validator = Validator::make($request->all(), [

                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email',
                'picture' => 'required|image',
                'phone_number' => 'required|string|max:50',
                'old_password' => 'required',

            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages()->first(),
            ], 400);
        } else {
            if ($request->all()['new_password'] != "undefined"
                || $request->all()['repeat_new_password'] != "undefined") {
                if ($request->all()['new_password'] != $request->all()['repeat_new_password']) {
                    return response()->json([
                        'status' => 400,
                        'message' => "New password and repeat password must be the same",
                    ], 400);
                }

            }

            $picture = $request->file('picture');
            // error_log(print_r($request->file('picture')->getClientOriginalName(),TRUE));
            $new_picture = time() . $admin->first_name . '-' . $admin->last_name;
            // $new_picture=time().$picture->getClientOriginalName();
            if (File::exists($admin->picture)) {
                File::delete($admin->picture);
            }
            $picture->move(public_path() . '/uploads/admins/', $new_picture);
            if ($request->all()['new_password'] == "undefined") {
                Admins::where('id', $id)
                    ->update(['first_name' => $request->all()['first_name'],
                        'last_name' => $request->all()['last_name'],
                        'email' => $request->all()['email'],
                        'phone_number' => $request->all()['phone_number'],
                        'password' => bcrypt($request->all()['old_password']),
                        'picture' => 'uploads/admins/' . $new_picture,
                    ]
                    );
            } else {
                Admins::where('id', $id)
                    ->update(['first_name' => $request->all()['first_name'],
                        'last_name' => $request->all()['last_name'],
                        'email' => $request->all()['email'],
                        'phone_number' => $request->all()['phone_number'],
                        'password' => bcrypt($request->all()['new_password']),
                        'picture' => 'uploads/admins/' . $new_picture,
                    ]
                    );
            }

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
        //
        $admin = Admins::where('id', $id);

        if (File::exists($admin->first()->picture)) {
            File::delete($admin->first()->picture);
        }

        if ($admin->count() > 0) {

            $admin->delete();
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
