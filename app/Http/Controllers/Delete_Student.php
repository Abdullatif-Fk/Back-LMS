<?php

namespace App\Http\Controllers;

use App\Models\Students;
use App\Models\Students_Attendances;
use File;

class Delete_Student extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Students::where('id', $id);
        $student_att = Students_Attendances::where("student_id", $id);

        if (File::exists($student->first()->picture)) {
            File::delete($student->first()->picture);
        }

        if ($student->count() > 0) {
            if ($student_att) {
                $student_att->delete();
            }

            $student->delete();

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
