<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Students;
use App\Models\Sections;
class Classes extends Model
{
    protected $table='Classes';
    public $timestamps = false;
    use HasFactory;

    protected $fillable = [
        'id',
        'name'
    ];


    public function sections()
    {
        return $this->hasMany(Sections::class, 'class_id','id');
    }
    
}
