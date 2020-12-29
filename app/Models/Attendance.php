<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Students;

class Attendance extends Model
{
    protected $table='Attendance';
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
        'status'
    ];

    public function students()
    {
        return $this->belongsToMany(Students::class, 'Students_Attendances','attendance_id','student_id');
    }
}
