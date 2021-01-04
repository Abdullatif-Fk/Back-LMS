<?php

namespace App\Models;

use App\Models\Attendance;
use App\Models\Sections;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $table = "Students";
    public $timestamps = false;
    use HasFactory;
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'picture',
        'section_id',
    ];
    public function attendance()
    {
        return $this->belongsToMany(Attendance::class, 'Students_Attendances', 'student_id', 'attendance_id');
    }
    public function Sections()
    {
        return $this->belongsTo(Sections::class, 'section_id', 'id');
    }

}
