<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Classes;

use App\Models\Attendance;

class Students extends Model
{
    protected $table ="Students";
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number',
        'picture',
        'class_id'
    ];
    public function attendance()
    {
        return $this->belongsToMany(Attendance::class, 'Students_Attendances','student_id','attendance_id');
    }
    public function classes()
    {
        return $this->belongsTo(Classes::class,'class_id','id');
    }
 
}
