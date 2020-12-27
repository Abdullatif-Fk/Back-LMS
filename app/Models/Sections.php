<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Classes;

class Sections extends Model
{
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
}
