<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students_Attendances extends Model
{
    protected $table='Students_Attendances';
    use HasFactory;

    protected $fillable = [
        'date',
        'attendance_id',
        'student_id',
    ];
}
