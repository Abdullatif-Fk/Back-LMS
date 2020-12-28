<?php

namespace App\Http\Controllers;
use App\Models\Students;

use Illuminate\Http\Request;

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
        $student = Students::where('id',$id);
        
        if ($student->count() > 0) {
            $student->delete();
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
