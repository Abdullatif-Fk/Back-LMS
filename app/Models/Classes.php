<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Students;
use App\Models\Sections;
class Classes extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function students()
    {
        return $this->hasMany(Students::class, 'class_id','id');
    }

    public function sections()
    {
        return $this->hasMany(Sections::class, 'class_id','id');
    }
    
}
