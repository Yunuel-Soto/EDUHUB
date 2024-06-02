<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function relationSubCareer()
    {
        return $this->hasMany(relation_sub_career::class);
    }

    public function teacherSchedules()
    {
        return $this->hasMany(TeacherSchedule::class);
    }

    public function assistances()
    {
        return $this->hasMany(Assistance::class);
    }

}
