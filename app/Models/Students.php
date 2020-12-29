<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Sections;

use App\Models\Attendance;

class Students extends Model
{
    protected $table ="Students";
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone_number',
        'picture',
        'section_id'
    ];
    public function attendance()
    {
        return $this->belongsToMany(Attendance::class, 'Students_Attendances','student_id','attendance_id');
    }
    public function Sections()
    {
        return $this->belongsTo(Sections::class,'sections_id','id');
    }
 
}
