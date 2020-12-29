<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Classes;
use App\Models\Students;


class Sections extends Model
{
    protected $table='Sections';
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
        'name',
        'max_students',
        'class_id',
    ];
    public function classes()
    {
        return $this->belongsTo(Classes::class,'class_id','id');
    }

    public function students()
    {
        return $this->hasMany(Students::class, 'class_id','id');
    }
}

